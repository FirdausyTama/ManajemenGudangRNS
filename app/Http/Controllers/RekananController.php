<?php

namespace App\Http\Controllers;

use App\Models\Rekanan;
use App\Models\DokumenRekanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Exports\RekananExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class RekananController
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');
        $status = $request->input('status');

        $query = Rekanan::withCount('dokumenRekanans')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_rekanan', 'like', "%{$search}%")
                  ->orWhere('nama_perusahaan', 'like', "%{$search}%")
                  ->orWhere('nama_pic', 'like', "%{$search}%");
            });
        }

        if ($jenis) {
            $query->where('jenis_rekanan', $jenis);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $rekanans = $query->paginate(10)->withQueryString();

        return view('admin.rekanan.index', compact('rekanans'));
    }

    public function create()
    {
        return view('admin.rekanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_rekanan' => 'required',
            'nama_perusahaan' => 'required|string|max:255',
            'nama_pic' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'dokumen.*' => 'nullable|file|max:20480', // 20MB
            'kategori_dokumen.*' => 'required_with:dokumen.*'
        ]);

        DB::beginTransaction();
        try {
            $rekanan = Rekanan::create([
                'jenis_rekanan' => $request->jenis_rekanan,
                'nama_perusahaan' => $request->nama_perusahaan,
                'nama_pic' => $request->nama_pic,
                'jabatan_pic' => $request->jabatan_pic,
                'no_hp' => $request->no_hp,
                'email' => $request->email,
                'npwp' => $request->npwp,
                'nib' => $request->nib,
                'alamat' => $request->alamat,
                'kota' => $request->kota,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'website' => $request->website,
                'status' => $request->status ?? 'Aktif',
                'catatan' => $request->catatan,
                'created_by' => auth()->id(),
            ]);

            if ($request->hasFile('dokumen')) {
                foreach ($request->file('dokumen') as $key => $file) {
                    if ($file->isValid()) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('dokumen_rekanan', $filename, 'public');
                        
                        DokumenRekanan::create([
                            'rekanan_id' => $rekanan->id,
                            'nama_dokumen' => $file->getClientOriginalName(),
                            'kategori_dokumen' => $request->kategori_dokumen[$key] ?? 'Dokumen Lainnya',
                            'file_path' => $path,
                            'nama_file' => $filename,
                            'ukuran_file' => $file->getSize(),
                            'tipe_file' => $file->getClientOriginalExtension(),
                            'uploaded_by' => auth()->id(),
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('rekanan.index')->with('success', 'Rekanan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menambahkan rekanan: ' . $e->getMessage());
        }
    }

    public function show(Rekanan $rekanan)
    {
        $rekanan->load('dokumenRekanans');
        return view('admin.rekanan.show', compact('rekanan'));
    }

    public function edit(Rekanan $rekanan)
    {
        return view('admin.rekanan.edit', compact('rekanan'));
    }

    public function update(Request $request, Rekanan $rekanan)
    {
        $request->validate([
            'jenis_rekanan' => 'required',
            'nama_perusahaan' => 'required|string|max:255',
        ]);

        $rekanan->update([
            'jenis_rekanan' => $request->jenis_rekanan,
            'nama_perusahaan' => $request->nama_perusahaan,
            'nama_pic' => $request->nama_pic,
            'jabatan_pic' => $request->jabatan_pic,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'npwp' => $request->npwp,
            'nib' => $request->nib,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'kode_pos' => $request->kode_pos,
            'website' => $request->website,
            'status' => $request->status ?? 'Aktif',
            'catatan' => $request->catatan,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('rekanan.show', $rekanan->id)->with('success', 'Rekanan berhasil diupdate.');
    }

    public function destroy(Rekanan $rekanan)
    {
        // soft delete rekanan
        $rekanan->delete();
        return redirect()->route('rekanan.index')->with('success', 'Rekanan berhasil dihapus.');
    }

    public function uploadDokumen(Request $request, Rekanan $rekanan)
    {
        $request->validate([
            'dokumen.*' => 'required|file|max:20480',
            'kategori_dokumen.*' => 'required'
        ]);

        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $key => $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('dokumen_rekanan', $filename, 'public');
                    
                    DokumenRekanan::create([
                        'rekanan_id' => $rekanan->id,
                        'nama_dokumen' => $file->getClientOriginalName(),
                        'kategori_dokumen' => $request->kategori_dokumen[$key] ?? 'Dokumen Lainnya',
                        'file_path' => $path,
                        'nama_file' => $filename,
                        'ukuran_file' => $file->getSize(),
                        'tipe_file' => $file->getClientOriginalExtension(),
                        'uploaded_by' => auth()->id(),
                    ]);
                }
            }
        }
        return back()->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function destroyDokumen($id)
    {
        $dokumen = DokumenRekanan::findOrFail($id);
        if (Storage::exists($dokumen->file_path)) {
            Storage::delete($dokumen->file_path);
        }
        $dokumen->delete();
        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');
        $status = $request->input('status');

        $query = Rekanan::withCount('dokumenRekanans')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_rekanan', 'like', "%{$search}%")
                  ->orWhere('nama_perusahaan', 'like', "%{$search}%")
                  ->orWhere('nama_pic', 'like', "%{$search}%");
            });
        }
        if ($jenis) { $query->where('jenis_rekanan', $jenis); }
        if ($status) { $query->where('status', $status); }

        $rekanans = $query->get();

        return Excel::download(new RekananExport($rekanans), 'Data_Rekanan_'.date('Y-m-d').'.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $search = $request->input('search');
        $jenis = $request->input('jenis');
        $status = $request->input('status');

        $query = Rekanan::withCount('dokumenRekanans')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_rekanan', 'like', "%{$search}%")
                  ->orWhere('nama_perusahaan', 'like', "%{$search}%")
                  ->orWhere('nama_pic', 'like', "%{$search}%");
            });
        }
        if ($jenis) { $query->where('jenis_rekanan', $jenis); }
        if ($status) { $query->where('status', $status); }

        $rekanans = $query->get();

        $pdf = Pdf::loadView('admin.rekanan.pdf', compact('rekanans'))->setPaper('a4', 'landscape');
        return $pdf->download('Data_Rekanan_'.date('Y-m-d').'.pdf');
    }
}

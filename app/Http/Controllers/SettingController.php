<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SettingController
{
    /**
     * Tampilkan halaman pengelolaan setting
     */
    public function index()
    {
        return view('admin.settings');
    }

    /**
     * Proses penyimpanan setting baru/update
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // Cek apakah key merupakan file upload (tipe image)
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                // Simpan ke storage/app/public/settings
                $path = $file->store('settings', 'public');
                
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $path, 'type' => 'image']
                );
            } else {
                // Tipe text biasa
                if ($value !== null) {
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value, 'type' => 'text']
                    );
                }
            }
        }

        // Hapus cache agar landing page memuat versi terbaru setting
        Cache::forget('landing_settings');

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }

    /**
     * Kembalikan semua pengaturan ke bawaan awal
     */
    public function reset()
    {
        // Hapus semua data dr database
        Setting::truncate();
        
        // Hapus semua file di folder public/settings
        $files = Storage::disk('public')->files('settings');
        Storage::disk('public')->delete($files);

        // Hapus cache
        Cache::forget('landing_settings');

        return back()->with('success', 'Semua pengaturan telah dikembalikan ke standar awal (Default).');
    }

    /**
     * Hapus satu gambar spesifik (contoh: hero_image_1)
     */
    public function deleteImage($key)
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting && $setting->type === 'image') {
            // Hapus file fisik
            if (Storage::disk('public')->exists($setting->value)) {
                Storage::disk('public')->delete($setting->value);
            }
            // Hapus dari database
            $setting->delete();

            // Refresh cache
            Cache::forget('landing_settings');

            return back()->with('success', 'Gambar berhasil dihapus.');
        }

        return back()->with('error', 'Gambar tidak ditemukan.');
    }
}

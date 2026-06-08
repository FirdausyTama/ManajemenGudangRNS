<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;

class ResetPasswordController
{
    /**
     * Tampilkan form Lupa Password (input email)
     */
    public function showLinkRequestForm()
    {
        return view('Auth.forgot-password');
    }

    /**
     * Kirim link reset password ke email
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.'
        ]);

        // Cek status user (opsional, jika ingin mencegah user pending mereset password)
        $user = User::where('email', $request->email)->first();
        if ($user && $user->status !== 'active') {
            return back()->withErrors(['email' => 'Akun belum aktif atau sedang menunggu persetujuan.']);
        }

        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Link reset password telah dikirim ke email Anda! Silakan periksa Kotak Masuk atau folder Spam.');
        }

        return back()->withErrors(['email' => 'Gagal mengirim link reset. Silakan coba lagi.']);
    }

    /**
     * Tampilkan form Reset Password (input password baru)
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('Auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Lakukan reset password (update ke database)
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(),
                'max:32'
            ],
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.letters' => 'Password harus mengandung setidaknya satu huruf.',
            'password.numbers' => 'Password harus mengandung setidaknya satu angka.',
            'password.symbols' => 'Password harus mengandung setidaknya satu simbol.',
        ]);

        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Kata sandi Anda telah berhasil direset! Silakan login dengan kata sandi baru Anda.');
        }

        return back()->withErrors(['email' => 'Link reset tidak valid atau sudah kadaluarsa. Silakan minta link baru.']);
    }
}

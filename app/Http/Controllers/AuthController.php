<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('buyer.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $inputEmail = strtolower(trim($validated['email']));
        $password = $validated['password'];

        // 1. Strict Admin Authentication
        if ($inputEmail === 'admin@marjukis.test') {
            if (Auth::attempt(['email' => $inputEmail, 'password' => $password], $request->remember)) {
                $request->session()->regenerate();
                // Direct explicit redirect to admin.dashboard to prevent intended API route redirect bugs
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang kembali, Administrator!');
            }
            return back()->withErrors(['email' => 'Password Admin yang Anda masukkan salah.'])->withInput();
        }

        // 2. Flexible Buyer Authentication (Auto Login / Auto Register for Buyer)
        $user = User::where('email', $inputEmail)->first();

        if (!$user) {
            // Auto-create buyer account on the fly for seamless demo
            $name = explode('@', $inputEmail)[0];
            $name = ucwords(str_replace(['.', '_', '-'], ' ', $name));

            $user = User::create([
                'name' => $name ?: 'Pelanggan Kedai',
                'email' => str_contains($inputEmail, '@') ? $inputEmail : $inputEmail . '@gmail.com',
                'password' => Hash::make($password),
                'role' => 'buyer',
                'phone' => '0882005116301',
                'address' => 'JL. Jomblang Perbalan No 800 Candi, Semarang',
            ]);
        }

        Auth::login($user, $request->remember);
        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang kembali, Administrator!');
        }

        return redirect()->route('home')
            ->with('success', 'Selamat datang, ' . $user->name . '! Silakan pilih menu hidangan favoritmu.');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('buyer.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'phone.required' => 'Nomor WhatsApp / HP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $cleanPhone = preg_replace('/[^0-9]/', '', $validated['phone']);
        $email = $cleanPhone ? $cleanPhone . '@marjukis.test' : Str::slug($validated['name']) . '@gmail.com';

        $user = User::where('email', $email)->orWhere('phone', $validated['phone'])->first();

        if (!$user) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $email,
                'phone' => $validated['phone'],
                'address' => 'Diambil / Makan di Tempat Kedai Marjuki\'S',
                'password' => Hash::make($validated['password']),
                'role' => 'buyer',
            ]);
        }

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Pendaftaran akun berhasil! Selamat datang di Kedai Marjuki\'S.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('info', 'Anda telah keluar dari akun.');
    }
}

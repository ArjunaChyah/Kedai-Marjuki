<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
                return redirect()->intended(route('admin.dashboard'))
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
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali, Administrator!');
        }

        return redirect()->intended(route('home'))
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
            'email' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'password' => ['required', 'string', 'min:4'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 4 karakter.',
        ]);

        $email = strtolower(trim($validated['email']));
        if (!str_contains($email, '@')) {
            $email .= '@gmail.com';
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $email,
                'phone' => $validated['phone'] ?? '0882005116301',
                'address' => $validated['address'] ?? 'JL. Jomblang Perbalan No 800 Candi, Semarang',
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

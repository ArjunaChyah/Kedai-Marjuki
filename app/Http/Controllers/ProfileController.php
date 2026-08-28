<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('buyer.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'old_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'address.required' => 'Alamat rumah wajib diisi.',
            'old_password.required_with' => 'Password lama wajib diisi untuk mengubah password.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (!empty($request->password)) {
            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->withErrors(['old_password' => 'Password lama yang Anda masukkan tidak sesuai.']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profil Anda berhasil diperbarui.');
    }
}

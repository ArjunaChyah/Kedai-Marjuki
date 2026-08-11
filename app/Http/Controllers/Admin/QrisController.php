<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrisSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QrisController extends Controller
{
    public function index()
    {
        $qrisSettings = QrisSetting::latest()->get();
        $activeQris = QrisSetting::active()->first();

        return view('admin.qris.index', compact('qrisSettings', 'activeQris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'qris_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string|max:500',
        ], [
            'qris_image.required' => 'Gambar QRIS wajib diunggah.',
            'qris_image.image' => 'File harus berupa gambar.',
            'qris_image.mimes' => 'Format file harus jpg, jpeg, png, atau webp.',
            'qris_image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $path = $request->file('qris_image')->store('qris', 'public');

        // Deactivate all existing ones if making this active
        $isFirst = QrisSetting::count() === 0;

        $qris = QrisSetting::create([
            'qris_image' => $path,
            'description' => $request->description ?? 'QRIS Kedai Marjuki\'S',
            'is_active' => $isFirst, // Auto activate if first QRIS
        ]);

        return redirect()->route('admin.qris.index')
            ->with('success', 'Gambar QRIS baru berhasil diunggah.' . ($isFirst ? ' Dan langsung diaktifkan.' : ''));
    }

    public function activate(QrisSetting $qris)
    {
        // Deactivate all other QRIS settings
        QrisSetting::query()->update(['is_active' => false]);

        // Activate selected QRIS
        $qris->update(['is_active' => true]);

        return redirect()->route('admin.qris.index')
            ->with('success', 'QRIS terpilih telah diaktifkan untuk pembayaran.');
    }

    public function destroy(QrisSetting $qris)
    {
        if ($qris->is_active) {
            return redirect()->route('admin.qris.index')
                ->with('error', 'Tidak dapat menghapus QRIS yang sedang aktif. Aktifkan QRIS lain terlebih dahulu.');
        }

        if ($qris->qris_image && Storage::disk('public')->exists($qris->qris_image)) {
            Storage::disk('public')->delete($qris->qris_image);
        }

        $qris->delete();

        return redirect()->route('admin.qris.index')
            ->with('success', 'Gambar QRIS berhasil dihapus.');
    }
}

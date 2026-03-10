<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // Menampilkan halaman Data Alat
    public function index()
    {
        $items = Item::orderBy('created_at', 'desc')->get();
        return view('admin.items', compact('items'));
    }

    // Menyimpan Alat Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|string',
            'foto' => 'image|mimes:jpeg,png,jpg,webp|max:2048', // Maksimal 2MB
        ]);

        $data = $request->all();

        // Jika ada file foto yang diupload
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('alat', 'public');
        }

        Item::create($data);
        return redirect()->back()->with('success', 'Alat baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|string',
            'foto' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $item = Item::findOrFail($id);
        $data = $request->all();

        // Jika Admin mengubah foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('alat', 'public');
        }

        $item->update($data);
        return redirect()->back()->with('success', 'Data alat berhasil diperbarui!');
    }

    // Menghapus Data Alat
    public function destroy($id)
    {
        Item::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Alat berhasil dihapus dari sistem!');
    }
}
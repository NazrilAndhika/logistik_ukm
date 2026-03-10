<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    // Menampilkan daftar anggota (hanya yang role-nya 'user')
    public function index()
    {
        $anggota = User::where('role', 'user')->orderBy('created_at', 'desc')->get();
        return view('admin.anggota', compact('anggota'));
    }

    // Menghapus akun anggota
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data anggota berhasil dihapus dari sistem!');
    }
}
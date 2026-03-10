<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class UserController extends Controller
{
    public function index()
    {
        // 1. CEK ROLE: Kalau yang login ini Admin, tendang ke Dashboard Admin
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // 2. CEK KETERLAMBATAN: Cari apakah user ini punya barang telat
        $cekTerlambat = \App\Models\Transaction::where('user_id', Auth::id())
                        ->where('status', 'Dipinjam')
                        ->whereDate('tgl_kembali', '<', \Carbon\Carbon::today())
                        ->exists(); // Menghasilkan true jika ada yang telat

        $items = \App\Models\Item::all(); 
        
        // Lempar variabel $cekTerlambat ke tampilan
        return view('user.index', compact('items', 'cekTerlambat'));
    }

    // Fungsi baru untuk memproses peminjaman
    public function storePinjam(Request $request)
    {
        // dd($request->all());
        // 1. Validasi inputan dari form
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'jumlah' => 'required|integer|min:1',
            'tgl_kembali' => 'required|date|after_or_equal:today',
        ]);

        // 2. Simpan ke database transactions
        Transaction::create([
            'user_id' => Auth::id(), // ID user yang sedang login
            'item_id' => $request->item_id, // ID barang yang dipilih
            'jumlah' => $request->jumlah,
            'tgl_pinjam' => now(), // Tanggal hari ini
            'tgl_kembali' => $request->tgl_kembali,
            'status' => 'Pending',
        ]);

        // 3. Kembalikan ke halaman katalog dengan pesan sukses
        return redirect()->back()->with('success', 'Pengajuan pinjam berhasil dikirim! Menunggu validasi admin.');
    }

    // Fungsi untuk menampilkan halaman Status Peminjaman
    public function statusPeminjaman()
    {
        // Ambil data transaksi khusus untuk user yang sedang login
        // dan statusnya hanya 'Pending' atau 'Dipinjam'
        $peminjaman = Transaction::with('item')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['Pending', 'Dipinjam'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.status', compact('peminjaman'));
    }

    // Fungsi untuk menampilkan halaman Riwayat Peminjaman
    // Cari fungsi riwayat milik User, lalu sesuaikan query-nya jadi begini:
    public function riwayatPeminjaman()
    {
        $riwayat = \App\Models\Transaction::with('item')
                    ->where('user_id', Auth::id())
                    // TINGGAL TAMBAHKAN STATUS BARUNYA DI BAWAH INI:
                    ->whereIn('status', ['Selesai', 'Selesai (Terlambat)', 'Ditolak'])
                    ->orderBy('updated_at', 'desc')
                    ->paginate(5);
                    
        return view('user.riwayat', compact('riwayat')); // Sesuaikan dengan nama view kamu ya
    }

    // Menampilkan halaman profil
    public function editProfile()
    {
        $user = Auth::user(); // Ambil data user yang sedang login
        return view('user.profile', compact('user'));
    }

    // Menyimpan update profil ke database
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nim' => 'nullable|string|max:20|unique:users,nim,' . $user->id,
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'no_hp' => 'nullable|string|max:20',
            'prodi' => 'nullable|string|max:255',
            'kelas' => 'nullable|string|max:50',
        ]);

        // Simpan data (kita gunakan cara ini agar tidak kena error fillable)
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nim = $request->nim;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->no_hp = $request->no_hp;
        $user->prodi = $request->prodi;
        $user->kelas = $request->kelas;
        $user->save();

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
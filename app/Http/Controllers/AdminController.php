<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Menghitung angka untuk Stat Cards
        $totalAlat = Item::count();
        $menungguValidasi = Transaction::where('status', 'Pending')->count();
        $sedangDipinjam = Transaction::where('status', 'Dipinjam')->count();
        $totalSelesai = Transaction::where('status', 'Selesai')->count();

        // Mengambil 5 pengajuan terbaru yang berstatus Pending untuk Quick Table
        $pendingTransactions = Transaction::with(['user', 'item'])
                                ->where('status', 'Pending')
                                ->latest()
                                ->take(5)
                                ->get();

        return view('admin.index', compact(
            'totalAlat', 
            'menungguValidasi', 
            'sedangDipinjam', 
            'totalSelesai', 
            'pendingTransactions'
        ));
    }

    // Menampilkan semua pengajuan yang berstatus Pending
    public function validasi()
    {
        $pendingTransactions = Transaction::with(['user', 'item'])
                                ->where('status', 'Pending')
                                ->orderBy('created_at', 'asc') // Yang ngajukan duluan, tampil di atas
                                ->get();
                                
        return view('admin.validasi', compact('pendingTransactions'));
    }

    // Fungsi Setujui Peminjaman
    public function setujui($id)
    {
        $trx = Transaction::findOrFail($id);
        $item = Item::findOrFail($trx->item_id);

        // Cek apakah stok alat masih cukup
        if ($item->stok >= $trx->jumlah) {
            // Kurangi stok barang utama
            $item->decrement('stok', $trx->jumlah);
            // Ubah status transaksi
            $trx->update(['status' => 'Dipinjam']);

            return redirect()->back()->with('success', 'Pengajuan disetujui! Stok alat berhasil dikurangi.');
        }

        return redirect()->back()->with('error', 'Gagal! Stok alat tidak mencukupi untuk jumlah yang dipinjam.');
    }

    // Fungsi Tolak Peminjaman
    public function tolak($id)
    {
        $trx = Transaction::findOrFail($id);
        $trx->update(['status' => 'Ditolak']);

        return redirect()->back()->with('success', 'Pengajuan berhasil ditolak.');
    }

    // Menampilkan halaman Pengembalian (Hanya yang statusnya 'Dipinjam')
    public function pengembalian()
    {
        $borrowedTransactions = Transaction::with(['user', 'item'])
                                ->where('status', 'Dipinjam')
                                ->orderBy('tgl_kembali', 'asc') // Urutkan dari tenggat waktu terdekat
                                ->get();
                                
        return view('admin.pengembalian', compact('borrowedTransactions'));
    }

    // Proses klik tombol Kembalikan (Stok Bertambah)
    public function kembalikan($id)
    {
        $trx = Transaction::findOrFail($id);
        $item = Item::findOrFail($trx->item_id);

        // 1. Kembalikan stok barang ke database
        $item->increment('stok', $trx->jumlah);

        // 2. CEK KETERLAMBATAN
        $tglKembali = \Carbon\Carbon::parse($trx->tgl_kembali)->startOfDay();
        $hariIni = \Carbon\Carbon::today();

        if ($hariIni->gt($tglKembali)) {
            // Jika hari ini lebih besar dari jadwal kembali -> Berarti Telat
            $trx->update(['status' => 'Selesai (Terlambat)']);
        } else {
            // Jika dikembalikan tepat waktu atau lebih awal
            $trx->update(['status' => 'Selesai']);
        }

        return redirect()->back()->with('success', 'Barang berhasil dikembalikan dan stok logistik otomatis bertambah!');
    }

    // Menampilkan semua riwayat transaksi untuk laporan
    // Menampilkan semua riwayat transaksi untuk laporan (Dilengkapi Date Filter)
    // Menampilkan semua riwayat transaksi untuk laporan (Dilengkapi Date Filter)
    public function riwayat(Request $request)
    {
        // 1. Siapkan kerangka query dasar (urutkan dari yang terbaru)
        $query = Transaction::with(['user', 'item'])->orderBy('updated_at', 'desc');

        // 2. Jika Admin mengisi filter tanggal, maka saring datanya
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date != '' && $request->end_date != '') {
            $start_date = $request->start_date;
            // Gunakan endOfDay() agar data di hari terakhir sampai jam 23:59 ikut terbaca
            $end_date = \Carbon\Carbon::parse($request->end_date)->endOfDay(); 
            
            // Saring berdasarkan tanggal pinjam (bisa juga tgl_kembali sesuai kebutuhan LPJ)
            $query->whereBetween('tgl_pinjam', [$start_date, $end_date]);
        }

        // 3. Eksekusi query untuk mengambil data
        $riwayat = $query->paginate(5)->withQueryString();
                    
        return view('admin.riwayat', compact('riwayat'));
    }
}
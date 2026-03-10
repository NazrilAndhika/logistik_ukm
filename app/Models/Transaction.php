<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];

    // Relasi ke User (Satu transaksi milik satu user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Item (Satu transaksi meminjam satu barang)
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
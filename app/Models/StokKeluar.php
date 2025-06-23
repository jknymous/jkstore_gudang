<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokKeluar extends Model
{
    use HasFactory;

    protected $fillable = ['barang_id', 'toko_id', 'jumlah', 'keterangan', 'created_by'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

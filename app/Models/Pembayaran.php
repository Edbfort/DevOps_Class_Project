<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayaran';

    protected $primaryKey = 'id';


    protected $fillable = [
        'id',
        'id_pengguna',
        'status_bayar'.
        'status_pembayaran'.
        'kode_pembayaran',
        'deskripsi'
    ];

    protected $dates = [
        'waktu_buat',
        'waktu_ubah'
    ];
    public $timestamps = false;

    protected $casts = [
        'waktu_buat' => 'datetime',
        'waktu_ubah' => 'datetime',
    ];

    public $incrementing = true;

    protected $keyType = 'int';
}

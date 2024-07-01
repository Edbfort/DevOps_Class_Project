<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';


    protected $fillable = [
        'id_pengguna',
        'status_pembayaran'.
        'kode_pembayaran',
        'deskripsi',
        'waktu_buat',
        'waktu_ubah'
    ];

    public $timestamps = false;

    protected $casts = [
        'waktu_buat' => 'datetime',
        'waktu_ubah' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Di sini, tidak perlu mengatur waktu_buat karena sudah diatur oleh database
        });

        static::updating(function ($model) {
            // Di sini, mengatur waktu_ubah karena sudah diatur oleh database
            $model->waktu_ubah = $model->freshTimestamp();
        });
    }
}

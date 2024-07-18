<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'milestone';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_proyek',
        'topik',
        'deskripsi',
        'tautan',
        'persentase',
        'tanggal_tegat',
        'status',
        'waktu_buat',
        'waktu_ubah',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

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

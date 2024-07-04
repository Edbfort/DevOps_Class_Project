<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingRekening extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'billing_rekening';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pengguna',
        'id_bank',
        'nomor_rekening',
        'nama_pemilik',
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

        static::saving(function ($model) {
            if ($model->exists) {
                // Set waktu_ubah to the current timestamp when updating a record
                $model->waktu_ubah = $model->freshTimestamp();
            } else {
                // Set waktu_buat to the current timestamp when creating a new record
                $model->waktu_buat = $model->freshTimestamp();
            }
        });
    }
}

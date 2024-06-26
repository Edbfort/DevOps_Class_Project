<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataProductOwner extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'data_product_owner';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pengguna',
        'nama',
        'lokasi',
        'detail_deskripsi',
        'waktu_buat',
        'waktu_ubah',
    ];

    /**
     * Set default attributes.
     *
     * @var array
     */
    protected $attributes = [
        'waktu_buat' => 'CURRENT_TIMESTAMP',
        'waktu_ubah' => 'CURRENT_TIMESTAMP',
    ];
}

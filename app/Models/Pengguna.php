<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengguna';

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
        'id_user',
        'nomor_telepon',
        'alamat',
        'profil_detail',
        'website',
        'tag_line',
        'spesialisasi',
        'sosial_media',
        'fee',
        'id_status_pengguna',
        'waktu_buat',
        'waktu_ubah'
    ];

    public function idUser()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function idStatusPengguna()
    {
        return $this->belongsTo(StatusPengguna::class, 'id_status_pengguna', 'id');
    }
}

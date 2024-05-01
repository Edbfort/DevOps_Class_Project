<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komunitas extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'komunitas';

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
        'id_jenis_komunitas',
        'nama_komunitas',
        'pembuat',
        'deskripsi',
        'waktu_buat',
        'waktu_ubah'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    public function idUser()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function idStatusPengguna()
    {
        return $this->belongsTo(StatusPengguna::class, 'id_status_pengguna', 'id');
    }

}

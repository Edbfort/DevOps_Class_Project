<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

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
        'id_status_pengguna',
        'uid',
        'username',
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

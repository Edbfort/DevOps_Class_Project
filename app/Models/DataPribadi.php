<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPribadi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'data_pribadi';

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
        'nama_ig',
        'nama_linkedin',
        'nama_facebook',
        'nama_github',
        'project_link',
        'tanggal_lahir',
        'tempat_lahir',
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
}

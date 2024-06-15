<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileTeam extends Model
{
    use HasFactory;

    protected $table = 'profile_team';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_creative_hub',
        'deskripsi',
        'nama_team',
        'skillset',
        'waktu_buat',
        'waktu_ubah'
    ];

    public $timestamps = false;
}

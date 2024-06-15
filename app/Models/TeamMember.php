<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $table = 'team_members';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_team_profile',
        'path_foto_profile',
        'nama',
        'waktu_buat',
        'waktu_ubah'
    ];

    public $timestamps = false; // Since we are handling timestamps manually
}

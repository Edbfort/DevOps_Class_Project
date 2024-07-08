<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberTeam extends Model
{
    use HasFactory;

    protected $table = 'member_team';

    protected $fillable = [
        'id_team',
        'nama',
        'jabatan',
        'role_team',
        'waktu_buat',
        'waktu_ubah'
    ];

    protected $dates = [
        'waktu_buat',
        'waktu_ubah'
    ];
    public $timestamps = false;

    protected $casts = [
        'waktu_buat' => 'datetime',
        'waktu_ubah' => 'datetime',
    ];
}

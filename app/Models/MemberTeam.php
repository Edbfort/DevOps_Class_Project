<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MemberTeam extends Model
{
    use HasFactory;
    protected $table = 'member_team';

    protected $primaryKey = 'id';


    protected $fillable = [
        'id_profile_team',
        'nama',
        'peran_team',
        'jabatan',
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

    public $incrementing = true;

    protected $keyType = 'int';
}

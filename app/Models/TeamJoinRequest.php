<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamJoinRequest extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'team_join_request';

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
        'id',
        'id_team',
        'id_user',
        'jabatan',
        'status_terima',
        'waktu_buat',
        'waktu_ubah'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    public function idTeam()
    {
        return $this->belongsTo(Team::class, 'id_komunitas', 'id');
    }
    public function idPengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }

}

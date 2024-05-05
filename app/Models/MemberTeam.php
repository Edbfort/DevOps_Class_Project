<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberTeam extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_team';

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
    public function idUser()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

}

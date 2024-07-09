<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LamaranProyek extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lamaran_proyek';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_proyek',
        'id_team',
        'status',
        'waktu_buat',
        'waktu_ubah'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->exists) {
                // Set waktu_ubah to the current timestamp when updating a record
                $model->waktu_ubah = $model->freshTimestamp();
            } else {
                // Set waktu_buat to the current timestamp when creating a new record
                $model->waktu_buat = $model->freshTimestamp();
            }
        });
    }

    public function idProyek()
    {
        return $this->belongsTo(Proyek::class, 'id_proyek', 'id');
    }

    public function idTeam()
    {
        return $this->belongsTo(Pengguna::class, 'id_team', 'id');
    }
}

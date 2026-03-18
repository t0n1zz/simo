<?php

namespace App\Models;

use App\Models\KegiatanListMateri;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nilai extends Model
{
    use Dataviewer, LogsActivity, SoftDeletes;
    protected $table = 'kegiatan_materi_nilai';

    protected $fillable = [
        'kegiatan_peserta_id', 'kegiatan_id', 'materi_id', 'nilai', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $allowedFilters = [
        'id', 'nilai',
    ];

    protected $orderable = [
        'id', 'nilai'
    ];

    public static function initialize()
    {
        return [
            'kegiatan_peserta_id' => '', 'kegiatan_id' => '', 'materi_id' => '', 'nilai' => ''
        ];
    }

    public static $rules = [
        'kegiatan_peserta_id' => 'required',
        'kegiatan_id' => 'required',
        'materi_id' => 'required',
        'nilai' => 'required',
    ];

    public function listMateri()
    {
        return $this->belongsTo(KegiatanListMateri::class, 'materi_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
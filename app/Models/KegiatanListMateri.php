<?php

namespace App\Models;

use App\Models\Nilai;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;

class KegiatanListMateri extends Model
{
    use LogsActivity, Dataviewer;

    protected $table = 'kegiatan_list_materi';

    public static $rules = [
        'kegiatan_id' => 'required',
        'nama' => 'required',
        'waktu' => 'required',
    ];

    protected $fillable = ['kegiatan_id', 'nama', 'waktu','narasumber'];

    protected $allowedFilters = ['kegiatan_id', 'nama', 'waktu','narasumber'];

    protected $orderable = ['kegiatan_id', 'nama', 'waktu','narasumber'];

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'materi_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
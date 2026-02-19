<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class KodeKegiatan extends Model
{
    use Dataviewer, LogsActivity;
    protected $table = 'kegiatan_kode';

    protected $fillable = [
        'kode', 'name', 'created_at', 'updated_at'
    ];

    protected $allowedFilters = [
        'id', 'kode', 'name'
    ];

    protected $orderable = [
        'id', 'kode', 'name'
    ];

    public static function initialize()
    {
        return [
            'kode' => '', 'name' => ''
        ];
    }

    public static $rules = [
        'kode' => 'required',
        'name' => 'required'
    ];

    public function hasKegiatan()
    {
        return $this->hasMany('App\Models\Kegiatan','id_kode','id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
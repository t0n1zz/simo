<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertifikatGetNomorPeserta extends Model
{
    use Dataviewer, LogsActivity, SoftDeletes;
    protected $table = 'sertifikat_get_nomor_peserta';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'sertifikat_get_nomor_id', 'nama', 'keterangan', 'created_at', 'updated_at'
    ];

    protected $allowedFilters = [
        'nama','keterangan', 'created_at'
    ];

    protected $orderable = [
        'id', 'nama','keterangan', 'created_at', 'updated_at'
    ];

    public static function initialize()
    {
        return [
            'sertifikat_get_nomor_id' => '', 'nama' => '', 'keterangan' => ''
            ];
    }

    public static $rules = [
        'nama' => 'required'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama',
                'onUpdate' => true
            ]
        ];
    }

    public function hasNomorPeserta(){
        return $this->hasMany('App\Models\SertifikatGenerate','sertifikat_get_nomor_peserta_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
class SertifikatGetNomor extends Model
{
 use Dataviewer, LogsActivity, SoftDeletes;
    protected $table = 'sertifikat_get_nomor';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'aktivis_id', 'kegiatan_name', 'jumlah_nomor_sertifikat', 'created_at', 'updated_at'
    ];

    protected $allowedFilters = [
        'kegiatan_name', 'jumlah_nomor_sertifikat', 'created_at'
    ];

    protected $orderable = [
        'id', 'kegiatan_name','aktivis_id', 'jumlah_nomor_sertifikat', 'created_at', 'updated_at'
    ];

    public static function initialize()
    {
        return [
            'aktivis_id' => '', 'kegiatan_name' => '', 'jumlah_nomor_sertifikat' => '', 
            ];
    }

    public static $rules = [
        'aktivis_id' => 'required',
        'kegiatan_name' => 'required',
        'jumlah_nomor_sertifikat' => 'required'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'kegiatan_name',
                'onUpdate' => true
            ]
        ];
    }

    public function hasNomor(){
        return $this->hasMany('App\Models\SertifikatGenerate','sertifikat_get_nomor_id','id');
    }
    public function peserta()
    {
        return $this->hasMany(SertifikatGetNomorPeserta::class, 'sertifikat_get_nomor_id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class AktivisOrganisasi extends BaseEloquent {

    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'aktivis_organisasi';

    protected $fillable = [
        'id_aktivis','tipe','name','jabatan','tempat','mulai','selesai'
    ];

    protected $filter = [
        'name','jabatan','tempat','mulai','selesai','created_at','updated_at'
    ];

    public static function initialize()
    {
        return ['aktif' => '', 'name' => '','jabatan' => '','tempat' => '','mulai' => '','selesai' => ''
        ];
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
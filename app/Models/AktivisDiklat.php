<?php
namespace App\Models;

use App\Models\Aktivis;
use App\Models\Kegiatan;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class AktivisDiklat extends BaseEloquent {

    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'aktivis_diklat';

    protected $fillable = [
        'id_aktivis','id_kegiatan','name','tempat','lembaga','mulai','selesai'
    ];

    protected $filter = [
        'name','id_kegiatan','tempat','lembaga','mulai','selesai','created_at','updated_at'
    ];

    public static function initialize()
    {
        return [
             'name' => '','id_kegiatan' => '','tempat' => '','lembaga' => '','mulai' => '','selesai' => ''
        ];
    }

    public function aktivis(){
        return $this->belongsTo(Aktivis::class,'id_aktivis','id');
    }

    public function kegiatan(){
        return $this->belongsTo(Kegiatan::class,'id_kegiatan','id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
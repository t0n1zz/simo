<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class AktivisDiklat extends BaseEloquent {

    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'aktivis_diklat';
    protected $dates = ['deleted_at'];

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
        return $this->belongsTo('App\Models\Aktivis','id_aktivis','id');
    }

    public function kegiatan(){
        return $this->belongsTo('App\Models\Kegiatan','id_kegiatan','id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
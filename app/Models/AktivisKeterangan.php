<?php
namespace App\Models;

use App\Models\Aktivis;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class AktivisKeterangan extends BaseEloquent {

    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'aktivis_keterangan';

    protected $fillable = [
        'id_aktivis','name','tipe','keterangan','tanggal'
    ];

    protected $filter = [
        'name','tipe','keterangan','created_at','updated_at','tanggal'
    ];

    public static function initialize()
    {
        return [
             'name' => '','tipe' => '','keterangan' => '','tanggal' => ''
        ];
    }

    public function aktivis(){
        return $this->belongsTo(Aktivis::class,'id_aktivis','id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
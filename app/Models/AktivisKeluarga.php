<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class AktivisKeluarga extends BaseEloquent {

    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'aktivis_keluarga';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_aktivis','name','tipe'
    ];

    protected $filter = [
        'name','tipe','created_at','updated_at'
    ];

    public static function initialize()
    {
        return [
             'name' => '','tipe' => ''
        ];
    }

    public function aktivis(){
        return $this->belongsTo('App\Models\Aktivis','id_aktivis','id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
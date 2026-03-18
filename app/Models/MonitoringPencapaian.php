<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class MonitoringPencapaian extends BaseEloquent {

    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'monitoring_pencapaian';

    public static $rules = [
        'id_monitoring' => 'required',
    ];

    
    protected $fillable = [
        'id_monitoring','pencapaian','bukti','kendala','tindak','catatan','gambar'
    ];

    protected $allowedFilters = [
        'id','id_monitoring','id_user','pencapaian','bukti','kendala','tindak','catatan','created_at','updated_at','gambar'
    ];

    protected $orderable = [
        'id','id_monitoring','id_user','pencapaian','bukti','kendala','tindak','catatan','created_at','updated_at','gambar'
    ];

    public static function initialize()
    {
        return [
            'id' => '','id_monitoring' => '','pencapaian' => '','bukti' => '','kendala' => '','tindak' => '','catatan' => '','gambar' => ''
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class MonitoringRekom extends BaseEloquent {

    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'monitoring_rekom';

    public static $rules = [
        'id_monitoring' => 'required',
    ];

    protected $fillable = [
        'id_monitoring','rekomendasi','status'
    ];

    protected $allowedFilters = [
        'id','id_monitoring','rekomendasi','status','created_at','updated_at',
    ];

    protected $orderable = [
        'id','id_monitoring','rekomendasi','status','created_at','updated_at',
    ];

    public static function initialize()
    {
        return [
            'id' => '','id_monitoring' => '','rekomendasi' => '','status' => ''
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
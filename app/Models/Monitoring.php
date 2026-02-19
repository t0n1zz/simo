<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class Monitoring extends BaseEloquent {

    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'monitoring';
    protected $dates = ['deleted_at'];

    public static $rules = [
        'id_cu' => 'required',
        'id_tp' => 'required',
        'id_aktivis_cu' => 'required',
        'id_aktivis_bkcu' => 'required',
        'name' => 'required',
        'jenis' => 'required',
        'aspek' => 'required',
    ];

    
    protected $fillable = [
        'id_cu','id_tp','id_aktivis_cu','id_aktivis_bkcu','name','jenis','aspek','rekomendasi','tanggal'
    ];

    protected $allowedFilters = [
        'id','id_cu','id_tp','id_aktivis_cu','id_aktivis_bkcu','name','jenis','aspek','tanggal','created_at','updated_at',
    ];

    protected $orderable = [
        'id','id_cu','id_tp','id_aktivis_cu','id_aktivis_bkcu','name','jenis','aspek','tanggal','created_at','updated_at',
    ];

    public static function initialize()
    {
        return [
            'id' => '','id_cu' => '','id_tp' => '','id_aktivis_cu' => '','id_aktivis_bkcu' => '','name' => '','jenis' => '','aspek' => '','rekomendasi' => '','tanggal' => ''
        ];
    }

    public function cu()
    {
        return $this->belongsTo('App\Models\Cu','id_cu','id')->select('id','no_ba','name');;
    }

    public function tp()
    {
        return $this->belongsTo('App\Models\Tp','id_tp','id')->select('id','no_tp','name');
    }

    public function aktivis_cu()
    {
        return $this->belongsTo('App\Models\Aktivis','id_aktivis_cu','id');
    }

    public function aktivis_bkcu()
    {
        return $this->belongsTo('App\Models\Aktivis','id_aktivis_bkcu','id');
    }

    public function monitoring_rekom()
    {
        return $this->hasMany('App\Models\MonitoringRekom','id_monitoring','id');
    }

    public function monitoring_rekom_ok()
    {
        return $this->hasMany('App\Models\MonitoringRekom','id_monitoring','id')->where('status',1);
    }

    public function monitoring_pencapaian()
    {
        return $this->hasMany('App\Models\MonitoringPencapaian','id_monitoring','id');
    }

    public function monitoring_rekom_last_year()
    {
        return $this->hasMany('App\Models\MonitoringRekom','id_monitoring','id')->select('id','id_monitoring');
    }

    public function monitoring_rekom_ok_last_year()
    {
        return $this->hasMany('App\Models\MonitoringRekom','id_monitoring','id')->select('id','id_monitoring','status')->where('status',1);
    }

    public function monitoring_rekom_last_month()
    {
        return $this->hasMany('App\Models\MonitoringRekom', 'id_monitoring', 'id')->select('id','id_monitoring');
    }

    public function monitoring_rekom_ok_last_month()
    {
        return $this->hasMany('App\Models\MonitoringRekom', 'id_monitoring', 'id')->select('id','id_monitoring','status')->where('status',1);
    }

    public function monitoring_pencapaian_latest()
    {
        return $this->hasOne('App\Models\MonitoringPencapaian', 'id_monitoring', 'id')->orderBy('created_at', 'desc');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
<?php
namespace App\Models;

use App\Models\Aktivis;
use App\Models\Cu;
use App\Models\MonitoringPencapaianCu;
use App\Models\MonitoringRekomCu;
use App\Models\Tp;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class MonitoringCu extends BaseEloquent {

    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'monitoring_cu';

    public static $rules = [
        'id_cu' => 'required',
        'id_tp' => 'required',
        'id_aktivis_pic' => 'required',
        'id_aktivis_pemeriksa' => 'required',
        'name' => 'required',
        'jenis' => 'required',
        'aspek' => 'required',
    ];

    
    protected $fillable = [
        'id_cu','id_tp','id_aktivis_pic','id_aktivis_pemeriksa','name','jenis','aspek','rekomendasi','tanggal'
    ];

    protected $allowedFilters = [
        'id','id_cu','id_tp','id_aktivis_pic','id_aktivis_pemeriksa','name','jenis','aspek','tanggal','created_at','updated_at',
    ];

    protected $orderable = [
        'id','id_cu','id_tp','id_aktivis_pic','id_aktivis_pemeriksa','name','jenis','aspek','tanggal','created_at','updated_at',
    ];

    public static function initialize()
    {
        return [
            'id' => '','id_cu' => '','id_tp' => '','id_aktivis_pic' => '','id_aktivis_pemeriksa' => '','name' => '','jenis' => '','aspek' => '','rekomendasi' => '','tanggal' => ''
        ];
    }

    public function cu()
    {
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','no_ba','name');;
    }

    public function tp()
    {
        return $this->belongsTo(Tp::class,'id_tp','id')->select('id','no_tp','name');
    }

    public function aktivis_pic()
    {
        return $this->belongsTo(Aktivis::class,'id_aktivis_pic','id');
    }

    public function aktivis_pemeriksa()
    {
        return $this->belongsTo(Aktivis::class,'id_aktivis_pemeriksa','id');
    }

    public function monitoring_rekom()
    {
        return $this->hasMany(MonitoringRekomCu::class,'id_monitoring_cu','id');
    }

    public function monitoring_rekom_ok()
    {
        return $this->hasMany(MonitoringRekomCu::class,'id_monitoring_cu','id')->where('status',1);
    }

    public function monitoring_pencapaian()
    {
        return $this->hasMany(MonitoringPencapaianCu::class,'id_monitoring_cu','id');
    }

    public function monitoring_rekom_last_year()
    {
        return $this->hasMany(MonitoringRekomCu::class,'id_monitoring_cu','id')->select('id','id_monitoring_cu');
    }

    public function monitoring_rekom_ok_last_year()
    {
        return $this->hasMany(MonitoringRekomCu::class,'id_monitoring_cu','id')->select('id','id_monitoring_cu','status')->where('status',1);
    }

    public function monitoring_rekom_last_month()
    {
        return $this->hasMany(MonitoringRekomCu::class, 'id_monitoring_cu', 'id')->select('id','id_monitoring_cu');
    }

    public function monitoring_rekom_ok_last_month()
    {
        return $this->hasMany(MonitoringRekomCu::class, 'id_monitoring_cu', 'id')->select('id','id_monitoring_cu','status')->where('status',1);
    }

    public function monitoring_pencapaian_latest()
    {
        return $this->hasOne(MonitoringPencapaianCu::class, 'id_monitoring', 'id')->orderBy('created_at', 'desc');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
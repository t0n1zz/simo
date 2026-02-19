<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class MitraLembaga extends BaseEloquent {
    
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'mitra_lembaga';
    protected $dates = ['deleted_at'];

    public static $rules = [
        'name' => 'required'
    ];

    public static function boot()
    {
        parent::boot();
    }
    
    protected $fillable = [
        'id_villages','id_districts','id_regencies','id_provinces','no_ba','name','name_legal','gambar','badan_hukum','alamat','pos','telp','hp','website','email','created_at','updated_at','deleted_at','bidang','npwp','penanggungjawab','bentuk_kerjasama'    
    ];

    protected $allowedFilters = [
        'id','name','name_legal','badan_hukum','npwp','alamat','pos','telp','hp','website','email','created_at','updated_at','bidang','penanggungjawab','bentuk_kerjasama', 
        
        'villages.name', 'districts.name', 'regencies.name', 'provinces.name'
    ];

    protected $orderable = [
        'id','name','name_legal','badan_hukum','npwp','alamat','pos','telp','hp','website','email','created_at','updated_at','bidang','penanggungjawab','bentuk_kerjasama',
        
        'villages.name', 'districts.name', 'regencies.name', 'provinces.name'
    ];

    public static function initialize()
    {
        return [
            'id_villages' => '', 'id_districts' => '', 'id_regencies' => '', 'id_provinces' => '', 'name' => '', 'gambar' => '',
            'badan_hukum' => '','npwp' => '', 'alamat' => '', 'pos' => '', 'telp' => '', 'hp' => '', 'website' => '', 'email' => '', 'bidang' => ''
        ];
    }

    public function Provinces()
    {
        return $this->belongsTo('App\Models\Region\Provinces','id_provinces','id')->select('id','name');
    }
		
    public function Regencies()
    {
        return $this->belongsTo('App\Models\Region\Regencies','id_regencies','id')->select('id','name');
    }
		
    public function Districts()
    {
        return $this->belongsTo('App\Models\Region\Districts','id_districts','id')->select('id','name');
    }
		
    public function Villages()
    {
        return $this->belongsTo('App\Models\Region\Villages','id_villages','id')->select('id','name');
    }

    public function Cu()
    {
        return $this->belongsTo('App\Models\Cu','id_cu','id')->select('id','no_ba','name');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
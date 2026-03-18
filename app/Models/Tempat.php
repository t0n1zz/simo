<?php
namespace App\Models;

use App\Models\Region\Districts;
use App\Models\Region\Provinces;
use App\Models\Region\Regencies;
use App\Models\Region\Villages;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tempat extends BaseEloquent {
    
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'kegiatan_tempat';

    
    public static $rules = [
        'name' => 'required|between:3,50'
    ];
    
    protected $fillable = [
        'id_villages','id_districts','id_regencies','id_provinces','name','alamat','pos','telp','hp','website','email','gambar','created_at','updated_at','deleted_at'
    ];

    protected $allowedFilters = [
        'id','name','alamat','pos','telp','hp','website','email','created_at','updated_at','deleted_at',

        'villages.name', 'districts.name', 'regencies.name', 'provinces.name'
    ];

    protected $orderable = [
        'id','name','alamat','pos','telp','hp','website','email','created_at','updated_at','deleted_at',

        'villages.name', 'districts.name', 'regencies.name', 'provinces.name'
    ];

    public static function initialize(){
        return [
            'id_tempat' => '', 'id_villages' => '', 'id_districts' => '', 'id_regencies' => '', 'id_provinces' => '', 'name' => '', 'alamat' => '', 'gambar' => '','pos' => '', 'telp' => '', 'hp' => '', 'website' => '', 'email' => ''
        ];
    }
        
    public function Provinces()
    {
        return $this->belongsTo(Provinces::class,'id_provinces','id')->select('id','name');
    }
		
    public function Regencies()
    {
        return $this->belongsTo(Regencies::class,'id_regencies','id')->select('id','name');
    }
		
    public function Districts()
    {
        return $this->belongsTo(Districts::class,'id_districts','id')->select('id','name');
    }
		
    public function Villages()
    {
        return $this->belongsTo(Villages::class,'id_villages','id')->select('id','name');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
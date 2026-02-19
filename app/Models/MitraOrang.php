<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class MitraOrang extends BaseEloquent {
    
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'mitra_orang';
    protected $dates = ['deleted_at'];

    public static $rules = [
        'name' => 'required',
        'id_cu' => 'required'
    ];

    public static function boot()
    {
        parent::boot();
    }
    
    protected $fillable = [
        'nik','name','tempat_lahir','tanggal_lahir','kelamin','agama','status','alamat','hp','email','gambar','darah','tinggi','lembaga','pekerjaan_name','pendidikan_name','pekerjaan_tingkat','pendidikan_tingkat','kontak','gambar','id_villages','id_districts','id_regencies','id_provinces','bidang','npwp','id_cu'
    ];

    protected $allowedFilters = [
        'nik','name','tempat_lahir','tanggal_lahir','kelamin','agama','status','alamat','hp','email','darah','tinggi','lembaga','pekerjaan_name','pendidikan_name','kontak','created_at','updated_at','bidang','pekerjaan_tingkat','pendidikan_tingkat',
        
        'villages.name', 'districts.name', 'regencies.name', 'provinces.name', 'cu.name'
    ];

    protected $orderable = [
        'nim','nim_cu','nik','name','tempat_lahir','tanggal_lahir','kelamin','agama','status','alamat','hp','email','darah','tinggi','lembaga','pekerjaan_name','pendidikan_name','kontak','created_at','updated_at','bidang','pekerjaan_tingkat','pendidikan_tingkat',

        'villages.name', 'districts.name', 'regencies.name', 'provinces.name', 'cu.name'
    ];

    public static function initialize()
    {
        return [
            'nik' => '','name' => '','tempat_lahir' => '','tanggal_lahir' => '','kelamin' => '','agama' => '','status' => '','alamat' => '','hp' => '','email' => '','darah' => '','tinggi' => '','kontak' => '','lembaga' => '','pekerjaan_name' => '','pendidikan_name' => '','pekerjaan_tingkat' => '','pendidikan_tingkat' => '','gambar'=> '','id_villages' => '', 'id_districts' => '', 'id_regencies' => '', 'id_provinces' => '', 'bidang' => '', 'id_cu' => '',
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
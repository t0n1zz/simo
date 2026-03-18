<?php
namespace App\Models;

use App\Models\Aktivis;
use App\Models\Cu;
use App\Models\PemilihanCalon;
use App\Models\PemilihanSuara;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemilihan extends Model {
    
    use Dataviewer, LogsActivity,  SoftDeletes;

    protected $table = 'pemilihan';

    
    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'id_cu','name','status','created_at','updated_at','deleted_at','suara','suara_ok','suara_tipe','suara_akses','tingkat','pemilihan_min','pemilihan_max'
    ];

    protected $allowedFilters = [
        'id','id_cu','name','status','created_at','updated_at','deleted_at','suara','suara_ok','suara_tipe','suara_akses','tingkat','pemilihan_min','pemilihan_max',

        'cu.name',
    ];

    protected $orderable = [
        'id','id_cu','name','status','created_at','updated_at','deleted_at','suara','suara_ok','suara_tipe','suara_akses','pemilihan_min','pemilihan_max',

        'cu.name',
    ];
    
    public static function initialize(){
        return [
            'id_cu' => '', 'name' => '', 'status' => '',  'suara' => '',  'suara_ok' => '', 'tingkat' => '', 'sumberSuara' => '', 'suara_tipe' => '0', 'pemilihan_min' => '1', 'pemilihan_max' => '1'
        ];
    }

    public function Cu()
    {
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','no_ba','name');
    }

    public function calon(){
        return $this->belongsToMany(Aktivis::class,'pemilihan_calon')->withPivot('id','no_urut','skor','pengusung_cu_id')->withTimestamps();
    }

    public function hasCalon(){
        return $this->hasMany(PemilihanCalon::class,'pemilihan_id','id');
    }

    public function hasSuara(){
        return $this->hasMany(PemilihanSuara::class,'pemilihan_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
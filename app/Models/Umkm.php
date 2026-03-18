<?php
namespace App\Models;

use App\Models\AnggotaCu;
use App\Models\Cu;
use App\Models\KubnUsaha;
use App\Models\UmkmDiklat;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class Umkm extends BaseEloquent {

    use \Venturecraft\Revisionable\RevisionableTrait;
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'umkm';

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 500;
    
    public static $rules = [
        'anggota_cu_id' => 'required',
        'id_cu' => 'required'
    ];

    protected $fillable = [
        'anggota_cu_id','id_usaha','id_cu','jmlh_pinjaman','marketplace','deskripsi'
    ];

    protected $allowedFilters = [
        'id','anggota_cu_id','id_usaha','id_cu','jmlh_pinjaman','marketplace','deskripsi','created_at','updated_at',

        'anggota_cu.name','cu.name','usaha.name'
    ];

    protected $orderable = [
        'id','anggota_cu_id','id_usaha','id_cu','jmlh_pinjaman','marketplace','deskripsi','created_at','updated_at',

        'anggota_cu.name','cu.name','usaha.name'
    ];
    
    public static function initialize(){
        return [
            'anggota_cu_id' => '', 'id_usaha' => '','id_cu' => '','jmlh_pinjaman' => '0','marketplace' => '', 'deskripsi' => ''
        ];
    }

    public function anggota_cu()
    {
        return $this->belongsTo(AnggotaCu::class,'anggota_cu_id','id');
    }

    public function Cu()
    {
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','no_ba','name','id_provinces')->withTrashed();
    }

    public function Usaha()
    {
        return $this->belongsTo(KubnUsaha::class,'id_usaha','id')->select('id','name')->withTrashed();
    }

    public function Diklat()
    {
        return $this->hasMany(UmkmDiklat::class,'id_umkm','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
<?php
namespace App\Models;

use App\Models\AnggotaCu;
use App\Models\Cu;
use App\Models\KubnDiklat;
use App\Models\KubnUsaha;
use App\Models\Region\Districts;
use App\Models\Region\Provinces;
use App\Models\Region\Regencies;
use App\Models\Region\Villages;
use App\Models\Tp;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class Kubn extends BaseEloquent {

    use \Venturecraft\Revisionable\RevisionableTrait;
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'kubn';

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 500;

    public static $rules = [
        'id_cu' => 'required',
        'name' => 'required',
    ];

    public static function boot()
    {
        parent::boot();
    }

    protected $dontKeepRevisionOf = array(
        'deleted_at'
    );
    
    protected $fillable = [
        'id_cu','id_tp','id_usaha','name','id_villages','id_districts','id_regencies','id_provinces','jmlh_pinjaman','tanggal_berdiri','tipe_anggota','jmlh_anggota','gambar','deskripsi'
    ];

    protected $allowedFilters = [
        'id','id_cu','id_usaha','name','jmlh_pinjaman','tanggal_berdiri','tipe_anggota','jmlh_anggota','deskripsi',

        'villages.name', 'districts.name', 'regencies.name', 'provinces.name','cu.name','tp.name','usaha.name'
    ];

    protected $orderable = [
        'id','id_cu','id_usaha','name','jmlh_pinjaman','tanggal_berdiri','jmlh_anggota','deskripsi',

        'villages.name', 'districts.name', 'regencies.name', 'provinces.name','cu.name','tp.name','usaha.name'
    ];

    public static function initialize()
    {
        return [
            'id_cu' => '','id_tp' => '','id_usaha' => '','name' => '','id_villages' => '','id_districts' => '','id_regencies' => '','id_provinces' => '','jmlh_pinjaman' => '0','jmlh_anggota' => '0','tanggal_berdiri' => '','gambar' => '','deskripsi' => '','tipe_anggota' => ''
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

    public function Cu()
    {
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','no_ba','name','id_provinces')->withTrashed();
    }

    public function Tp()
    {
        return $this->belongsTo(Tp::class,'id_tp','id')->select('id','name')->withTrashed();
    }

    public function Usaha()
    {
        return $this->belongsTo(KubnUsaha::class,'id_usaha','id')->select('id','name')->withTrashed();
    }

    public function Diklat()
    {
        return $this->hasMany(KubnDiklat::class,'id_kubn','id');
    }

    public function anggota_kubn(){
        return $this->belongsToMany(AnggotaCu::class,'kubn_anggota')->withPivot('jabatan','tanggal_mulai','tanggal_selesai','deskripsi')->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
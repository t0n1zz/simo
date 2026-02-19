<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Kegiatan extends Model {
    
    use Dataviewer, LogsActivity, Sluggable,  SoftDeletes;

    protected $table = 'kegiatan';

    protected $dates = ['deleted_at'];
    
    public static $rules = [
        // 'name' => 'required'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true
            ]
        ];
    }
    
    protected $fillable = [
      'tema','id_regencies','id_districts','id_regencies','id_provinces','id_tempat','id_sertifikat','id_sertifikatPanitia','id_kode','kode_diklat','name','periode','tahun_buku','durasi','mulai','selesai','jadwal','keterangan','keteranganBatal','status','tipe','peserta_max','peserta_max_cu','peserta_min','created_at','updated_at','deleted_at','gambar','tipe_tempat','keputusan_cu','keputusan_user','pertanyaan_cu','pertanyaan_user','isSasaran_cu'
    ];

    protected $allowedFilters = [
        'id','id_tempat','id_kode','kode_diklat','name','periode','tahun_buku','durasi','mulai','selesai','status','peserta_max','peserta_max_cu','peserta_min','created_at','updated_at','deleted_at','tipe_tempat',

        'villages.name', 'districts.name', 'regencies.name', 'provinces.name','tempat.name'
    ];

    protected $orderable = [
        'id','id_tempat','kode_diklat','name','periode','tahun_buku','durasi','mulai','selesai','status','peserta_max','peserta_max_cu','peserta_min','created_at','updated_at','deleted_at','tipe_tempat',

        'villages.name', 'districts.name', 'regencies.name', 'provinces.name','tempat.name'
    ];
    
    public static function initialize(){
        return [
            'tema' =>'','id_villages' => '', 'id_districts' => '', 'id_regencies' => '', 'id_provinces' => '', 'id_tempat' => '', 'kode_diklat' => '', 'name' => '', 'kota' => '', 'tipe' => '', 'periode' => '','tahun_buku' => '','durasi' => '', 'mulai' => '', 'selesai' => '','jadwal' => '', 'keterangan' => '', 'status' => '', 'peserta_max' => '', 'peserta_min' => '', 'gambar' => '', 'tipe_tempat' => '','isSasaran_cu' => ''
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
        
    public function tempat(){
        return $this->belongsTo('App\Models\Tempat','id_tempat','id');
    }

    public function sasaran(){
        return $this->belongsToMany('App\Models\Sasaran','kegiatan_sasaran')->withTimestamps();
    }

    public function sasaranCu(){
        return $this->belongsToMany('App\Models\Cu', 'kegiatan_sasaran_cu')->withTimestamps();
    }
    
    public function panitia_dalam(){
        return $this->belongsToMany('App\Models\Aktivis','kegiatan_panitia')->where('asal','dalam')->withPivot('peran','keterangan','asal', 'isGetSertifikat')->withTimestamps();
    }

    public function panitia_luar(){
        return $this->belongsToMany('App\Models\MitraOrang','kegiatan_panitia','kegiatan_id','aktivis_id')->where('asal','luar')->withPivot('peran','keterangan','asal', 'isGetSertifikat')->withTimestamps();
    }

    public function panitia_luar_lembaga(){
        return $this->belongsToMany('App\Models\MitraLembaga','kegiatan_panitia','kegiatan_id','aktivis_id')->where('asal','luar lembaga')->withPivot('peran','keterangan','asal', 'isGetSertifikat')->withTimestamps();
    }

    public function peserta(){
        return $this->belongsToMany('App\Peserta','kegiatan_peserta')->withTimestamps();
    }

    public function hasPeserta(){
        return $this->hasMany('App\Models\KegiatanPeserta','kegiatan_id','id');
    }

    public function hasMateri(){
        return $this->hasMany('App\Models\KegiatanMateri','kegiatan_id','id');
    }

    public function kode()
    {
        return $this->belongsTo('App\Models\KodeKegiatan', 'id_kode', 'id')->select('id', 'kode');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
<?php
namespace App\Models;

use App\Models\Aktivis;
use App\Models\Cu;
use App\Models\KegiatanMateri;
use App\Models\KegiatanPeserta;
use App\Models\KodeKegiatan;
use App\Models\MitraLembaga;
use App\Models\MitraOrang;
use App\Models\Region\Districts;
use App\Models\Region\Provinces;
use App\Models\Region\Regencies;
use App\Models\Region\Villages;
use App\Models\Sasaran;
use App\Models\Tempat;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Kegiatan extends Model {
    
    use Dataviewer, LogsActivity, Sluggable,  SoftDeletes;

    protected $table = 'kegiatan';

    
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
        
    public function tempat(){
        return $this->belongsTo(Tempat::class,'id_tempat','id');
    }

    public function sasaran(){
        return $this->belongsToMany(Sasaran::class,'kegiatan_sasaran')->withTimestamps();
    }

    public function sasaranCu(){
        return $this->belongsToMany(Cu::class, 'kegiatan_sasaran_cu')->withTimestamps();
    }
    
    public function panitia_dalam(){
        return $this->belongsToMany(Aktivis::class,'kegiatan_panitia')->where('asal','dalam')->withPivot('peran','keterangan','asal', 'isGetSertifikat')->withTimestamps();
    }

    public function panitia_luar(){
        return $this->belongsToMany(MitraOrang::class,'kegiatan_panitia','kegiatan_id','aktivis_id')->where('asal','luar')->withPivot('peran','keterangan','asal', 'isGetSertifikat')->withTimestamps();
    }

    public function panitia_luar_lembaga(){
        return $this->belongsToMany(MitraLembaga::class,'kegiatan_panitia','kegiatan_id','aktivis_id')->where('asal','luar lembaga')->withPivot('peran','keterangan','asal', 'isGetSertifikat')->withTimestamps();
    }

    public function peserta(){
        return $this->belongsToMany('App\Peserta','kegiatan_peserta')->withTimestamps();
    }

    public function hasPeserta(){
        return $this->hasMany(KegiatanPeserta::class,'kegiatan_id','id');
    }

    public function hasMateri(){
        return $this->hasMany(KegiatanMateri::class,'kegiatan_id','id');
    }

    public function kode()
    {
        return $this->belongsTo(KodeKegiatan::class, 'id_kode', 'id')->select('id', 'kode');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
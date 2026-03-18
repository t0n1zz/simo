<?php
namespace App\Models;

use App\Models\Cu;
use App\Models\Dokumen;
use App\Models\SuratKategori;
use App\Models\SuratKode;
use App\Models\SuratKodeTemp;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model {
    
    use Dataviewer, LogsActivity,  SoftDeletes;

    protected $table = 'surat';

    
    public static $rules = [
        'id_surat_kode' => 'required',
        'id_surat_kategori' => 'required',
        'name' => 'required'
    ];

    protected $fillable = [
        'id_cu','id_surat_kode','id_surat_kategori','id_surat_kode_temp','id_dokumen','name','format','tipe','hal','keterangan','tujuan','periode','created_at','updated_at','deleted_at'
    ];

    protected $allowedFilters = [
        'id','id_cu','id_surat_kode','id_surat_kategori','id_surat_kode_temp','id_dokumen','name','hal','keterangan','periode','created_at','updated_at','deleted_at',

        'cu.name',
    ];

    protected $orderable = [
        'id','id_cu','id_surat_kode','id_surat_kategori','id_surat_kode_temp','id_dokumen','name','hal','keterangan','periode','created_at','updated_at','deleted_at',

        'cu.name',
    ];
    
    public static function initialize(){
        return [
            'id_cu' => '','id_surat_kategori' =>'','id_dokumen' =>'', 'name' => '','hal' => '', 'keterangan' => '',  'id_surat_kode' => '','periode' => '',
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(SuratKategori::class,'id_surat_kategori','id');
    }

    public function tipe()
    {
        return $this->belongsTo(SuratKode::class,'id_surat_kode','id');
    }

    public function Cu()
    {
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','no_ba','name');
    }

    public function temp()
    {
        return $this->belongsTo(SuratKodeTemp::class,'id','id_surat');
    }

    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class,'id_dokumen','id');
    }
    

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class SuratKategori extends BaseEloquent {
    
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'surat_kategori';
    protected $dates = ['deleted_at'];

    public static $rules = [
        'id_cu' => 'required',
        'id_surat_kode' => 'required',
        'name' => 'required',
    ];

    protected $fillable = ['id_cu','id_surat_kode','name','deskripsi'];

    protected $allowedFilters = [
        'id','id_cu','id_surat_kode','name','deskripsi','created_at','updated_at',
    ];

    protected $orderable = [
        'id','id_cu','id_surat_kode','name','deskripsi','created_at','updated_at','has_surat_count'
    ];

    public function surat(){
        return $this->hasMany('App\Models\Surat','id_surat_kategori','id')
            ->where('status','=','1')
            ->orderBy('created_at','desc')
            ->take(3);
    }
    

    public static function initialize(){
        return [
            'id_cu' => '', 'id_surat_kode' => '','name' => '', 'deskripsi' => '', 'periode' => ''
        ];
    }

    public function hassurat()
    {
        return $this->hasMany('App\Models\Surat','id_surat_kategori','id');
    }

    public function Cu()
    {
        return $this->belongsTo('App\Models\Cu','id_cu','id')->select('id','name');
    }

    public function kode()
    {
        return $this->belongsTo('App\Models\SuratKode','id_surat_kode','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
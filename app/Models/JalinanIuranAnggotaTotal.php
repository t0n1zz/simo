<?php
namespace App\Models;

use App\Models\JalinanIuranAnggota;
use App\Models\ProdukCu;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class JalinanIuranAnggotaTotal extends Model {
    
    use Dataviewer, LogsActivity,  SoftDeletes;

    protected $table = 'jalinan_iuran_anggota_total';

    
    public static $rules = [
        'jalinan_iuran_id' => 'required',
        'anggota_cu_id' => 'required',
    ];

    
    protected $fillable = [
        'jalinan_iuran_id','anggota_cu_id','total_simp','total_pinj','plafon','lokasi','created_at','updated_at','deleted_at'
    ];

    protected $allowedFilters = [
        'id','jalinan_iuran_id','anggota_cu_id','total_simp','total_pinj','plafon','lokasi','created_at','updated_at','deleted_at',

        'anggota_cu.name',
    ];

    protected $orderable = [
        'id','jalinan_iuran_id','anggota_cu_id','total_simp','total_pinj','plafon','lokasi','created_at','updated_at','deleted_at',

        'anggota_cu.name',
    ];
    
    public static function initialize(){
        return [
            'jalinan_iuran_id' => '', 'anggota_cu_id' => ''
        ];
    }

    public function produk()
    {
        return $this->belongsTo(ProdukCu::class,'produk_cu_id','id');
    }

    public function anggota()
    {
        return $this->hasMany(JalinanIuranAnggota::class,'anggota_cu_id','anggota_cu_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
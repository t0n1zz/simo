<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class Kombas extends BaseEloquent {
    
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'kombas';
    protected $dates = ['deleted_at'];

    public static $rules = [
        'name' => 'required',
    ];
    
    protected $fillable = ['id_cu','id_tp','name','deskripsi','gambar','jmlh_anggota','tanggal_berdiri','tipe'];

    protected $allowedFilters = [
        'id','id_cu','id_tp','name','deskripsi','tipe','created_at','updated_at','gambar','jmlh_anggota','tanggal_berdiri',

        'cu.name','tp.name'
    ];

    protected $orderable = [
        'id','id_cu','id_tp','name','deskripsi','tipe','created_at','updated_at','gambar','jmlh_anggota','tanggal_berdiri',

        'cu.name','tp.name'
    ];
    
    public static function initialize(){
        return [
            'id_cu' => '','id_tp' => '','name' => '','deskripsi' => '','gambar' => '','jmlh_anggota' => 0,'tanggal_berdiri' => '','tipe' => ''
        ];
    }

    public function Cu()
    {
        return $this->belongsTo('App\Models\Cu','id_cu','id')->select('id','no_ba','name','id_provinces')->withTrashed();
    }

    public function Tp()
    {
        return $this->belongsTo('App\Models\Tp','id_tp','id')->select('id','name')->withTrashed();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
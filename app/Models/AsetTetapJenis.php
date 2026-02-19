<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class AsetTetapJenis extends BaseEloquent {
    
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'aset_tetap_jenis';
    protected $dates = ['deleted_at'];

    public static $rules = [
        'aset_tetap_kelompok_id' => 'required',
        'kode'=> 'sometimes|required',
        'kode_unik' => 'sometimes|required|unique:aset_tetap_jenis',
        'name' => 'required',
    ];
    
    protected $fillable = ['aset_tetap_kelompok_id','kode','kode_unik','name','keterangan'];

    protected $allowedFilters = [
        'id','aset_tetap_kelompok_id','kode','name','keterangan','created_at','updated_at','has_aset_tetap_count',

        'kelompok.kode', 'kelompok.name'
    ];

    protected $orderable = [
        'id','aset_tetap_kelompok_id','kode','name','keterangan','created_at','updated_at','has_aset_tetap_count',

        'kelompok.kode', 'kelompok.name'
    ];

    public static function initialize(){
        return [
            'aset_tetap_kelompok_id' => '','kode' => '', 'name' => '', 'keterangan' => ''
        ];
    }

    public function kelompok()
    {
        return $this->belongsTo('App\Models\AsetTetapKelompok','aset_tetap_kelompok_id','id')->select('id','name','kode');
    }

    public function hasasettetap()
    {
        return $this->hasMany('App\Models\AsetTetap','aset_tetap_jenis_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
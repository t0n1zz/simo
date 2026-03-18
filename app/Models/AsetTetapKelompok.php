<?php
namespace App\Models;

use App\Models\AsetTetapGolongan;
use App\Models\AsetTetapJenis;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class AsetTetapKelompok extends BaseEloquent {
    
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'aset_tetap_kelompok';

    public static $rules = [
        'aset_tetap_golongan_id' => 'required',
        'kode'=> 'sometimes|required',
        'kode_unik' => 'sometimes|required|unique:aset_tetap_kelompok',
        'name' => 'required'
    ];
    
    protected $fillable = ['aset_tetap_golongan_id','kode','kode_unik','name','keterangan'];

    protected $allowedFilters = [
        'id','aset_tetap_golongan_id','kode','name','keterangan','created_at','updated_at','has_aset_tetap_count',

        'golongan.kode','golongan.name'
    ];

    protected $orderable = [
        'id','aset_tetap_golongan_id','kode','name','keterangan','created_at','updated_at','has_aset_tetap_count',

        'golongan.kode','golongan.name'
    ];

    public static function initialize(){
        return [
            'aset_tetap_golongan_id' => '','kode' => '', 'name' => '', 'keterangan' => ''
        ];
    }

    public function golongan()
    {
        return $this->belongsTo(AsetTetapGolongan::class,'aset_tetap_golongan_id','id')->select('id','name','kode');
    }

    public function hasjenis()
    {
        return $this->hasMany(AsetTetapJenis::class,'aset_tetap_jenis_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
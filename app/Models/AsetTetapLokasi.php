<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class AsetTetapLokasi extends BaseEloquent {
    
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'aset_tetap_lokasi';
    protected $dates = ['deleted_at'];

    public static $rules = [
        'name' => 'required'
    ];
    
    protected $fillable = ['name','keterangan'];

    protected $allowedFilters = [
        'id','name','keterangan','created_at','updated_at','has_aset_tetap_count'
    ];

    protected $orderable = [
        'id','name','keterangan','created_at','updated_at','has_aset_tetap_count'
    ];

    public static function initialize(){
        return [
            'name' => '', 'keterangan' => ''
        ];
    }

    public function hasasettetap()
    {
        return $this->hasMany('App\Models\AsetTetap','aset_tetap_lokasi_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
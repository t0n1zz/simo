<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;

class KegiatanRekom extends Model {
    
    use LogsActivity, Dataviewer;

    protected $table = 'kegiatan_rekom';

    public static $rules = [
        'name' => 'required'
    ];
    
    protected $fillable = [
        'kegiatan_id','name','pic','waktu','tipe','no'
    ];

    protected $allowedFilters = [
        'kegiatan_id','name','pic','waktu','tipe','created_at','updated_at','no'
    ];

    protected $orderable = [
        'kegiatan_id','name','pic','waktu','tipe','created_at','updated_at','no'
    ];

    public function Kegiatan(){
        return $this->belongsTo('App\Models\Kegiatan','kegiatan_id','id');
    }

    public function hasil(){
        return $this->hasMany('App\Models\KegiatanRekomHasil','kegiatan_rekom_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
<?php
namespace App\Models;

use App\Models\Kegiatan;
use App\Models\KegiatanRekomHasil;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
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
        return $this->belongsTo(Kegiatan::class,'kegiatan_id','id');
    }

    public function hasil(){
        return $this->hasMany(KegiatanRekomHasil::class,'kegiatan_rekom_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
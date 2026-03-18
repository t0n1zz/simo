<?php
namespace App\Models;

use App\Models\Cu;
use App\Models\KegiatanPertanyaan;
use App\Models\KegiatanPilih;
use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;

class KegiatanPertanyaan extends Model {
    
    use LogsActivity, Dataviewer;

    protected $table = 'kegiatan_pertanyaan';

    public static $rules = [
        'id_user' => 'required',
        'id_cu' => 'required'
    ];
    
    protected $fillable = ['kegiatan_id','kegiatan_pertanyaan_id','id_user','id_cu','keterangan','terjawab'];

    protected $allowedFilters = ['kegiatan_id','user.username','user.aktivis.name','cu.name','created_at','updated_at'];

    protected $orderable = ['kegiatan_id','user.username','user.aktivis.name','cu.name','created_at','updated_at'];

    public function cu(){
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','name','no_ba');;
    }

    public function user(){
        return $this->belongsTo(User::class,'id_user','id')->select('id','id_cu','id_aktivis','username');;
    }

    public function pilih(){
        return $this->belongsToMany(KegiatanPilih::class,'kegiatan_pilih_pivot')->withPivot('nilai')->withTimestamps();
    }

    public function haskomentar()
    {
        return $this->hasMany(KegiatanPertanyaan::class,'kegiatan_pertanyaan_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
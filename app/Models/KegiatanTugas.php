<?php
namespace App\Models;

use App\Models\Cu;
use App\Models\KegiatanTugasJawaban;
use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;

class KegiatanTugas extends Model {
    
    use LogsActivity, Dataviewer;

    protected $table = 'kegiatan_tugas';

    public static $rules = [
        'id_user' => 'required',
        'id_cu' => 'required'
    ];
    
    protected $fillable = ['kegiatan_id','kegiatan_tugas_id','id_user','id_cu','name','tipe','format','filename','link','keterangan'];

    protected $allowedFilters = ['kegiatan_id','user.username','user.aktivis.name','cu.name','created_at','updated_at','name','keterangan'];

    protected $orderable = ['kegiatan_id','user.username','user.aktivis.name','cu.name','created_at','updated_at','name'];

    public function cu(){
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','name','no_ba');;
    }

    public function user(){
        return $this->belongsTo(User::class,'id_user','id')->select('id','id_cu','id_aktivis','username');;
    }

    public function hasjawaban()
    {
        return $this->hasMany(KegiatanTugasJawaban::class,'kegiatan_tugas_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
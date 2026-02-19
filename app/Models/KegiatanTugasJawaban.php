<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;

class KegiatanTugasJawaban extends Model {
    
    use LogsActivity, Dataviewer;

    protected $table = 'kegiatan_tugas_jawaban';

    public static $rules = [
        'id_user' => 'required',
        'id_cu' => 'required'
    ];
    
    protected $fillable = ['kegiatan_tugas_id','id_user','id_cu','format','filename','link','keterangan'];

    protected $allowedFilters = ['user.username','user.aktivis.name','cu.name','created_at','updated_at','name'];

    protected $orderable = ['user.username','user.aktivis.name','cu.name','created_at','updated_at','name'];

    public function cu(){
        return $this->belongsTo('App\Models\Cu','id_cu','id')->select('id','name','no_ba');;
    }

    public function user(){
        return $this->belongsTo('App\Models\User','id_user','id')->select('id','id_cu','id_aktivis','username');;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
<?php
namespace App\Models;

use App\Models\Cu;
use App\Models\Kegiatan;
use App\Models\VotingPilihan;
use App\Models\VotingSuara;
use App\Models\VotingTanggapan;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voting extends Model {
    
    use Dataviewer, LogsActivity,  SoftDeletes;

    protected $table = 'voting';

    
    public static $rules = [
        'name' => 'required'
    ];

    protected $fillable = [
        'id_cu','id_kegiatan','name','name_kegiatan','status','created_at','updated_at','deleted_at','suara','suara_ok','suara_tipe','suara_akses','keterangan','lihat_hasil'
    ];

    protected $allowedFilters = [
        'id','id_cu','id_kegiatan','name','name_kegiatan','status','created_at','updated_at','deleted_at','suara','suara_ok','suara_tipe','suara_akses','keterangan','lihat_hasil',

        'cu.name',
    ];

    protected $orderable = [
        'id','id_cu','id_kegiatan','name','name_kegiatan','status','created_at','updated_at','deleted_at','suara','suara_ok','suara_tipe','suara_akses','lihat_hasil',

        'cu.name',
    ];
    
    public static function initialize(){
        return [
            'id_cu' => '','id_kegiatan' =>'', 'name' => '','name_kegiatan', 'status' => '',  'suara' => '',  'suara_ok' => '', 'suara_tipe' => '0', 'sumberSuara' => '','keterangan' => '','lihat_hasil' => ''
        ];
    }

    public function Cu()
    {
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','no_ba','name');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class,'id_kegiatan','id')->select('id','name');
    }

    public function pilihan(){
        return $this->hasMany(VotingPilihan::class,'voting_id','id');
    }

    public function tanggapan(){
        return $this->hasMany(VotingTanggapan::class,'voting_id','id');
    }

    public function hasSuara(){
        return $this->hasMany(VotingSuara::class,'voting_id','id');
    }
    

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
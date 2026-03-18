<?php
namespace App\Models;

use App\Models\Cu;
use App\Models\Voting;
use App\Models\VotingPilihan;
use App\Models\VotingSuaraAkses;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;
use Illuminate\Database\Eloquent\SoftDeletes;

class VotingSuara extends Model {

    use LogsActivity, Dataviewer, SoftDeletes;

    protected $table = 'voting_suara';


    protected $fillable = [
        'voting_id','voting_pilihan_id','id_cu','name','created_at','updated_at','isTanggapan'
    ];

    protected $allowedFilters = [
        'id','voting_id','voting_pilihan_id','id_cu','name','created_at','updated_at','isTanggapan',
        'user.username'
    ];

    protected $orderable = [
        'id','voting_id','voting_pilihan_id','id_cu','name','created_at','updated_at','isTanggapan',
        'user.username'
    ];

    public static function initialize()
    {
        return [
            'voting_id' => '','voting_pilihan_id' => '','id_cu' => '','name' => ''
        ];
    }

    public function voting()
    {
        return $this->belongsTo(Voting::class,'voting_id','id');
    }

    public function pilihan()
    {
        return $this->belongsTo(VotingPilihan::class,'voting_pilihan_id','id');
    }

    public function cu()
    {
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','name');
    }

    public function akses()
    {
        return $this->belongsTo(VotingSuaraAkses::class,'id','voting_suara_id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
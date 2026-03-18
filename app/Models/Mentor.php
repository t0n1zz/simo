<?php
namespace App\Models;

use App\Models\AnggotaCu;
use App\Models\Cu;
use App\Models\Keahlian;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class Mentor extends BaseEloquent {

    use \Venturecraft\Revisionable\RevisionableTrait;
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'mentor';

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 500;
    
    public static $rules = [
        'anggota_cu_id' => 'required',
        'id_cu' => 'required'
    ];

    protected $fillable = [
        'anggota_cu_id','id_cu','deskripsi'
    ];

    protected $allowedFilters = [
        'id','anggota_cu_id','id_cu','deskripsi','created_at','updated_at',

        'anggota_cu.name','cu.name'
    ];

    protected $orderable = [
        'id','anggota_cu_id','id_cu','deskripsi','created_at','updated_at',

        'anggota_cu.name','cu.name'
    ];
    
    public static function initialize(){
        return [
            'anggota_cu_id' => '','id_cu' => '', 'deskripsi' => ''
        ];
    }

    public function anggota_cu()
    {
        return $this->belongsTo(AnggotaCu::class,'anggota_cu_id','id');
    }

    public function Cu()
    {
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','no_ba','name','id_provinces')->withTrashed();
    }

    public function keahlian(){
        return $this->belongsToMany(Keahlian::class,'mentor_keahlian')->withPivot('id','keahlian_id','mentor_id')->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
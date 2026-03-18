<?php
namespace App\Models;

use App\Models\Aktivis;
use App\Models\Cu;
use App\Models\Pemilihan;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemilihanCalon extends Model {

    use LogsActivity, Dataviewer, SoftDeletes;

    protected $table = 'pemilihan_calon';


    protected $fillable = [
        'no_urut','aktivis_id','pemilihan_id','pengusung_cu_id','skor','created_at','updated_at'
    ];

    protected $allowedFilters = [
        'id','no_urut','aktivis_id','pengusung_cu_id','pemilihan_id','skor','created_at','updated_at',
        'aktivis.name'
    ];

    protected $orderable = [
        'id','no_urut','aktivis_id','pengusung_cu_id','pemilihan_id','skor','created_at','updated_at',
        'aktivis.name'
    ];

    public static function initialize()
    {
        return [
            'no_urut' => '','aktivis_id' => '','pemilihan_id' => '','pengusung_cu_id' => '','skor' => ''
        ];
    }
    
    public function aktivis()
    {
        return $this->belongsTo(Aktivis::class,'aktivis_id','id');
    }

    public function cu()
    {
        return $this->belongsTo(Cu::class,'pengusung_cu_id','id');
    }

    public function pemilihan()
    {
        return $this->belongsTo(Pemilihan::class,'pemilihan_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
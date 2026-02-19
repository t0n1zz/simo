<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemilihanCalon extends Model {

    use LogsActivity, Dataviewer, SoftDeletes;

    protected $table = 'pemilihan_calon';

    protected $dates = ['deleted_at'];

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
        return $this->belongsTo('App\Models\Aktivis','aktivis_id','id');
    }

    public function cu()
    {
        return $this->belongsTo('App\Models\Cu','pengusung_cu_id','id');
    }

    public function pemilihan()
    {
        return $this->belongsTo('App\Models\Pemilihan','pemilihan_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
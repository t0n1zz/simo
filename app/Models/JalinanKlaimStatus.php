<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class JalinanKlaimStatus extends Model {
    
    use Dataviewer, LogsActivity;

    protected $table = 'jalinan_klaim_status';

    public static $rules = [
        'jalinan_klaim_id' => 'required'
    ];

    protected $fillable = [
        'jalinan_klaim_id', 'cu_id', 'status_klaim',
    ];

    protected $allowedFilters = [
        'id','jalinan_klaim_id', 'cu_id', 'status_klaim','created_at','updated_at'
    ];

    protected $orderable = [
        'id','jalinan_klaim_id', 'cu_id', 'status_klaim','created_at','updated_at'
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
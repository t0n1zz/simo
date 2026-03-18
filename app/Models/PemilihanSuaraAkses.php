<?php
namespace App\Models;

use App\Models\Voting;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemilihanSuaraAkses extends Model {

    use LogsActivity, Dataviewer, SoftDeletes;

    protected $table = 'pemilihan_suara_akses';


    protected $fillable = [
        'pemilihan_id','pemilihan_suara_id','created_at','updated_at'
    ];

    protected $allowedFilters = [
        'id','pemilihan_id','pemilihan_suara_id','created_at','updated_at',
    ];

    protected $orderable = [
        'id','pemilihan_id','pemilihan_suara_id','created_at','updated_at',
    ];

    public static function initialize()
    {
        return [
            'pemilihan_id' => '','name' => ''
        ];
    }

    public function pemilihan()
    {
        return $this->belongsTo(Voting::class,'pemilihan_id','id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
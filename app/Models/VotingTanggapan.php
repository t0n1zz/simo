<?php
namespace App\Models;

use App\Models\Voting;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;
use Illuminate\Database\Eloquent\SoftDeletes;

class VotingTanggapan extends Model {

    use LogsActivity, Dataviewer, SoftDeletes;

    protected $table = 'voting_tanggapan';


    protected $fillable = [
        'voting_id','name','created_at','updated_at'
    ];

    protected $allowedFilters = [
        'id','voting_id','name','created_at','updated_at',
    ];

    protected $orderable = [
        'id','voting_id','name','created_at','updated_at',
    ];

    public static function initialize()
    {
        return [
            'voting_id' => '','name' => ''
        ];
    }

    public function voting()
    {
        return $this->belongsTo(Voting::class,'voting_id','id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
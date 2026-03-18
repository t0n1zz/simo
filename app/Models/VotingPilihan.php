<?php
namespace App\Models;

use App\Models\Voting;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;
use Illuminate\Database\Eloquent\SoftDeletes;

class VotingPilihan extends Model {

    use LogsActivity, Dataviewer, SoftDeletes;

    protected $table = 'voting_pilihan';


    protected $fillable = [
        'voting_id','name','skor','skor_tanggapan','created_at','updated_at'
    ];

    protected $allowedFilters = [
        'id','voting_id','name','skor','skor_tanggapan','created_at','updated_at',
    ];

    protected $orderable = [
        'id','voting_id','name','skor','skor_tanggapan','created_at','updated_at',
    ];

    public static function initialize()
    {
        return [
            'voting_id' => '','name' => '','skor' => ''
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
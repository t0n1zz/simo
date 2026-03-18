<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class VotingPilihanCount extends Model {

    use LogsActivity;

    protected $table = 'voting_pilihan_count';

    protected $fillable = [
        'voting_id','voting_pilihan_id','voting_suara_id','created_at','updated_at'
    ];

    protected $allowedFilters = [
        'id','voting_id','voting_pilihan_id','voting_suara_id','created_at','updated_at'
    ];

    protected $orderable = [
        'id','voting_id','voting_pilihan_id','voting_suara_id','created_at','updated_at'
    ];

    public static function initialize()
    {
        return [
            'voting_id' => '','voting_pilihan_id' => '','voting_suara_id' => ''
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
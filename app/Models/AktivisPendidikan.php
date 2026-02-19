<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class AktivisPendidikan extends Model {

    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'aktivis_pendidikan';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_aktivis','name','tingkat','tempat','mulai','selesai'
    ];

    protected $filter = [
        'name','tingkat','tempat','mulai','selesai','created_at','updated_at'
    ];

    public static function initialize()
    {
        return [
             'name' => '','tingkat' => '','tempat' => '','mulai' => '','selesai' => ''
        ];
    }

    public function aktivis(){
        return $this->belongsTo('App\Models\Aktivis','id_aktivis','id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
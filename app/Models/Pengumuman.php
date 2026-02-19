<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class Pengumuman extends BaseEloquent
{
    use Dataviewer, LogsActivity;

    protected $table = 'pengumuman';

    public static $rules = [
        'name' => 'required|min:5'
    ];

    protected $fillable = [
        'id_cu','name'
    ];

    protected $allowedFilters = [
        'name','created_at','updated_at','cu.name'
    ];

    protected $orderable = [
        'name','created_at','updated_at','cu.name'
    ];

    public static function initialize()
    {
        return [
            'id_cu' => '' ,'name' => '' ,
        ];
    }

    public function cu()
    {
        return $this->belongsTo('App\Models\Cu','id_cu','id')->select('id','name');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}

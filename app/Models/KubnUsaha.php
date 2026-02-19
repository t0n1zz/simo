<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class KubnUsaha extends BaseEloquent {
    
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'kubn_usaha';
    protected $dates = ['deleted_at'];

    public static $rules = [
        'name' => 'required',
    ];
    
    protected $fillable = ['name','deskripsi'];

    protected $allowedFilters = [
        'id','name','deskripsi','created_at','updated_at','has_kubn_count'
    ];

    protected $orderable = [
        'id','name','deskripsi','created_at','updated_at','has_kubn_count'
    ];
    
    public static function initialize(){
        return [
             'name' => '', 'deskripsi' => ''
        ];
    }

    public function haskubn()
    {
        return $this->hasMany('App\Models\Kubn','id_usaha','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
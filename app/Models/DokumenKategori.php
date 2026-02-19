<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Cviebrock\EloquentSluggable\Sluggable;

class DokumenKategori extends BaseEloquent {
    
    use Dataviewer, LogsActivity, Sluggable, SoftDeletes;

    protected $table = 'dokumen_kategori';
    protected $dates = ['deleted_at'];

    public static $rules = [
        'id_cu' => 'required',
        'name' => 'required'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true
            ]
        ];
    }
    
    protected $fillable = ['id_cu','name','deskripsi'];

    protected $allowedFilters = [
        'id','id_cu','name','deskripsi','created_at','updated_at','has_dokumen_count'
    ];

    protected $orderable = [
        'id','id_cu','name','deskripsi','created_at','updated_at','has_dokumen_count'
    ];

    public static function initialize(){
        return [
            'id_cu' => '', 'name' => '', 'deskripsi' => ''
        ];
    }

    public function hasDokumen()
    {
        return $this->hasMany('App\Models\Dokumen','id_dokumen_kategori','id');
    }

    public function Cu()
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
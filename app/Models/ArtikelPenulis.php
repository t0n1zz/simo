<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Cviebrock\EloquentSluggable\Sluggable;

class ArtikelPenulis extends BaseEloquent {

    use Dataviewer, LogsActivity, Sluggable, SoftDeletes;
    
    protected $table = 'artikel_penulis';
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
    
    protected $fillable = ['id_cu','id_staf','name','deskripsi','gambar'];

    protected $allowedFilters = [
        'id','id_cu','name','deskripsi','gambar','utamakan','created_at','updated_at','has_artikel_count'
    ];

    protected $orderable = [
        'id','id_cu','name','deskripsi','gambar','utamakan','created_at','updated_at','has_artikel_count'
    ];

    public function artikel(){
        return $this->hasMany('App\Models\Artikel','id_artikel_penulis','id')
                    ->where('status','=','1')
                    ->orderBy('created_at','desc')
                    ->take(3);
    }

    public static function initialize()
    {
        return [
            'id_cu' => '','id_staf' => '', 'name' => '', 'deskripsi' => '','gambar' => '',
        ];
    }

    public function hasArtikel()
    {
        return $this->hasMany('App\Models\Artikel','id_artikel_penulis','id');
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
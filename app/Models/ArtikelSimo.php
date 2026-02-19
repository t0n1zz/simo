<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Cviebrock\EloquentSluggable\Sluggable;

class ArtikelSimo extends Model {

    use Dataviewer, LogsActivity, Sluggable;

    protected $table = 'artikel_simo';

    public static $rules = [
        'name' => 'required',
        'ringkasan' => 'required'
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
    
    protected $fillable = [
        'name','content','gambar','utamakan','ringkasan'
    ];

    protected $allowedFilters = [
        'id','name','content','gambar','utamakan','created_at','ringkasan'
    ];

    protected $orderable = [
        'id','name','content','gambar','utamakan','created_at', 'ringkasan'
    ];

    public static function initialize()
    {
        return [
            'name' => '','ringkasan' => '', 'content' => '', 'utamakan' => '', 'gambar' => ''
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Cviebrock\EloquentSluggable\Sluggable;

class Artikel extends BaseEloquent {

    use Dataviewer, LogsActivity, Sluggable, SoftDeletes;

    protected $table = 'artikel';
    protected $dates = ['deleted_at'];

    public static $rules = [
        'id_cu' => 'required',
        'id_artikel_kategori' => 'required',
        'id_artikel_penulis' => 'required',
        'name' => 'required|min:5'
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

    /**
     * Get the options for logging activity.
     */
    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
    
    protected $fillable = [
        'id_cu','id_artikel_kategori','id_artikel_penulis','name','content','terbitkan','gambar','gambar_thumb','utamakan'
    ];

    protected $allowedFilters = [
        'id','id_cu','id_artikel_kategori','id_artikel_penulis','name','content','terbitkan','gambar','utamakan','created_at','updated_at',
        
        'kategori.name','penulis.name','cu.name'
    ];

    protected $orderable = [
        'id','id_cu','id_artikel_kategori','id_artikel_penulis','name','content','terbitkan','gambar','utamakan','created_at','updated_at',
        
        'kategori.name','penulis.name','cu.name'
    ];

    public static function initialize()
    {
        return [
            'id_cu' => '' , 'id_artikel_kategori' => '','id_artikel_penulis' => '', 'name' => '', 'content' => '', 'terbitkan' => '', 'utamakan' => '', 'gambar' => ''
        ];
    }

    public function kategori()
    {
        return $this->belongsTo('App\Models\ArtikelKategori','id_artikel_kategori','id')->select('id','name','slug','created_at');
    }

    public function penulis()
    {
        return $this->belongsTo('App\Models\ArtikelPenulis','id_artikel_penulis','id');
    }

    public function Cu()
    {
        return $this->belongsTo('App\Models\Cu','id_cu','id')->select('id','no_ba','name');
    }
}
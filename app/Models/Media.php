<?php
namespace App\Models;

use App\Models\Cu;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;

class Media extends Model {
    
    use LogsActivity, Dataviewer;

    protected $table = 'media';

    public static $rules = [
        'id_cu' => 'required',
        'name' => 'required',
        'link' => 'required',
    ];
    
    protected $fillable = ['id_cu','name','gambar','link'];

    protected $allowedFilters = ['id_cu','name','cu.name'];

    protected $orderable = ['id_cu','name','cu.name'];

    public static function initialize()
    {
        return [
            'id_cu' => '' , 'name' => '','gambar' => '', 'link' => ''
        ];
    }

    public function Cu()
    {
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','no_ba','name');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
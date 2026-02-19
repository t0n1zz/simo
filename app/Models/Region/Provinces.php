<?php
namespace App\Models\Region;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use App\Support\FilterPaginateOrder;
use Spatie\Activitylog\Traits\LogsActivity;

class Provinces extends Model {
    
    use FilterPaginateOrder, LogsActivity;

    protected $table = 'provinces';

    public static $rules = [
        'name' => 'required',
    ];
    
    protected $fillable = ['name'];

    protected $filter = [
        'id','name','created_at','updated_at'
    ];

    public function getNameAttribute($value){
        return !empty($value) ? $value : '-';
    }

    public static function initialize(){
        return [
            'name' => ''
        ];
    }

    public function hasCu()
    {
        return $this->hasMany('App\Models\Cu','id_provinces','id')->select('id','id_provinces','name');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
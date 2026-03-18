<?php
namespace App\Models\Region;

use App\Models\Region\Provinces;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\FilterPaginateOrder;
use Spatie\Activitylog\Traits\LogsActivity;

class Regencies extends Model {
    
    use FilterPaginateOrder, LogsActivity;

    protected $table = 'regencies';

    public static $rules = [
        'province_id' => 'required',
        'name' => 'required',
    ];
    
    protected $fillable = ['province_id','name'];

    protected $filter = [
        'id','province_id','name','created_at','updated_at'
    ];

    public function getNameAttribute($value){
        return !empty($value) ? $value : '-';
    }

    public static function initialize(){
        return [
            'province_id' => '0', 'name' => ''
        ];
    }

    public function Provinces()
    {
        return $this->belongsTo(Provinces::class,'province_id','id')->select('id','name');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
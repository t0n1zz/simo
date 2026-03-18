<?php
namespace App\Models\Region;

use App\Models\Region\Districts;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\FilterPaginateOrder;
use Spatie\Activitylog\Traits\LogsActivity;

class Villages extends Model {
    
    use FilterPaginateOrder, LogsActivity;

    protected $table = 'villages';

    public static $rules = [
        'district_id' => 'required',
        'name' => 'required',
    ];
    
    protected $fillable = ['district_id','name'];

    protected $filter = [
        'id','district_id','name','created_at','updated_at'
    ];

    public function getNameAttribute($value){
        return !empty($value) ? $value : '-';
    }

    public static function initialize(){
        return [
            'district_id' => '0', 'name' => ''
        ];
    }

    public function Districts()
    {
        return $this->belongsTo(Districts::class,'district_id','id')->select('id','name');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
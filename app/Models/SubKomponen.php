<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\FilterPaginateOrder;
use Spatie\Activitylog\Traits\LogsActivity;

class SubKomponen extends Model
{
    use FilterPaginateOrder, LogsActivity;

    protected $table = 'evaluasi_sub_komponent';

    public static $rules = [
        'komponent' => 'required',
    ];

    protected $fillable = ['komponent'];

    protected $filter = [
        'id', 'evaluasi_komponent_id', 'komponent', 'created_at', 'updated_at'
    ];

    public static function initialize()
    {
        return [
            'komponent' => ''
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
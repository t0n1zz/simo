<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class LaporanCuDiskusi extends BaseEloquent {
    
    use LogsActivity;

    protected $table = 'laporan_cu_diskusi';

    public static $rules = [
        'content' => 'required'
    ];
    
    protected $fillable = ['id_laporan','id_user','content'];

    public function User(){
        return $this->belongsTo('App\Models\User','id_user','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
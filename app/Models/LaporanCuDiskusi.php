<?php
namespace App\Models;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class LaporanCuDiskusi extends BaseEloquent {
    
    use LogsActivity;

    protected $table = 'laporan_cu_diskusi';

    public static $rules = [
        'content' => 'required'
    ];
    
    protected $fillable = ['id_laporan','id_user','content'];

    public function User(){
        return $this->belongsTo(User::class,'id_user','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
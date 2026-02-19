<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class KegiatanMateriNilai extends Model {
    
    use LogsActivity;

    protected $table = 'kegiatan_materi_nilai';

    public static $rules = [
        'name' => 'required'
    ];
    
    protected $fillable = ['aktivis_id','kegiatan_id','materi_id','nilai'];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
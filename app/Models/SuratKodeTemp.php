<?php
namespace App\Models;

use App\Models\Surat;
use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class SuratKodeTemp extends Model {
    
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'surat_kode_temp';

    public static $rules = [
        'kode' => 'required',
    ];

    protected $fillable = ['id_surat_kode','id_user','id_surat','kode','periode'];

    protected $allowedFilters = [
        'id','id_surat_kode','id_user','id_surat','kode','created_at','updated_at',
    ];

    protected $orderable = [
        'id','id_surat_kode','id_user','id_surat','kode','created_at','updated_at'
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class,'id_surat','id')->select('id','kode');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'id_user','id')->select('id','username');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
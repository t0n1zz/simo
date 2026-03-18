<?php
namespace App\Models;

use App\Models\Cu;
use App\Models\Surat;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class SuratKode extends Model {
    
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'surat_kode';

    public static $rules = [
        'id_cu' => 'required',
        'name' => 'required',
        'kode' => 'required'
    ];

    protected $fillable = ['id_cu','name','kode','periode'];

    protected $allowedFilters = [
        'id','id_cu','name','kode','periode','created_at','updated_at',
    ];

    protected $orderable = [
        'id','id_cu','name','kode','periode','created_at','updated_at'
    ];

    public static function initialize(){
        return [
            'id_cu' => '', 'name' => '', 'kode' => '','periode' => ''
        ];
    }

    public function Cu()
    {
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','name');
    }

    public function hassurat()
    {
        return $this->hasMany(Surat::class,'id_surat_kode','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
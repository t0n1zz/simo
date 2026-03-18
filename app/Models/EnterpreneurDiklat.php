<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class EnterpreneurDiklat extends BaseEloquent {
    
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'enterpreneur_diklat';

    public static $rules = [
        'id_enterpreneur' => 'required',
        'name' => 'required',
    ];
    
    protected $fillable = ['id_enterpreneur','name','deskripsi','tanggal_mulai','tanggal_selesai','fasilitator','tempat'];

    protected $allowedFilters = [
        'id','id_enterpreneur','name','deskripsi','tanggal_mulai','tanggal_selesai','fasilitator','tempat','created_at','updated_at'
    ];

    protected $orderable = [
        'id','id_enterpreneur','name','deskripsi','tanggal_mulai','tanggal_selesai','fasilitator','tempat','created_at','updated_at'
    ];
    
    public static function initialize(){
        return [
            'id_enterpreneur' => '','name' => '', 'deskripsi' => '','tanggal_mulai' => '','tanggal_selesai' => '','fasilitator' => '','tempat' => ''
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class AktivisPekerjaan extends Model {

    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'aktivis_pekerjaan';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id_aktivis','id_tempat','id_tp','lembaga_lain','tipe','name','tingkat','mulai','selesai','status','keterangan_tidak_aktif'
    ];

    protected $filter = [
        'id_tempat','id_tp','tipe','name','tingkat','mulai','selesai','created_at','updated_at','status','keterangan_tidak_aktif'
    ];

    public static function initialize()
    {
        return [
            'id_tempat' => '','id_tp' => '','tipe' => '','lembaga_lain' => '','name' => '','tingkat' => '','mulai' => '','selesai' => '','status' => '', 'keterangan_tidak_aktif' => ''
        ];
    }

    public function aktivis(){
        return $this->belongsTo('App\Models\Aktivis','id_aktivis','id');
    }

    public function lembaga(){
        return $this->belongsTo('App\Lembaga','id_tempat','id')->select('id','name');
    }

    public function cu(){
        return $this->belongsTo('App\Models\Cu','id_tempat','id')->select('id','no_ba','name')->withTrashed();
    }

    public function tp(){
        return $this->belongsTo('App\Models\Tp','id_tp','id')->select('id','name')->withTrashed();
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
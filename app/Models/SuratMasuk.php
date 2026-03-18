<?php
namespace App\Models;

use App\Models\Cu;
use App\Models\Dokumen;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class SuratMasuk extends Model {
    
    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'surat_masuk';

    public static $rules = [
        'id_cu' => 'required',
        'hal' => 'required',
    ];

    protected $fillable = ['id_cu','id_dokumen','name','keterangan','hal','periode','pengirim','terima_melalui','tujuan','tanggal_terima'];

    protected $allowedFilters = [
        'id','id_cu','id_dokumen','name','keterangan','hal','periode','pengirim','terima_melalui','tujuan','tanggal_terima','created_at','updated_at',
    ];

    protected $orderable = [
        'id','id_cu','id_dokumen','name','keterangan','hal','periode','pengirim','terima_melalui','tujuan','tanggal_terima','created_at','updated_at'
    ];
    
    public static function initialize(){
        return [
            'id_cu' => '','id_dokumen' => '','name' => '','keterangan' => '','hal' => '','periode' => '','pengirim' => '','terima_melalui' => '','tujuan' => '','tanggal_terima' => ''
        ];
    }

    public function Cu()
    {
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','name');
    }

    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class,'id_dokumen','id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
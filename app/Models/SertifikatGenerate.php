<?php

namespace App\Models;

use App\Models\Kegiatan;
use App\Models\KegiatanPanitia;
use App\Models\KegiatanPeserta;
use App\Models\SertifikatGetNomor;
use App\Models\SertifikatGetNomorPeserta;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class SertifikatGenerate extends Model
{
  //
  use Dataviewer, LogsActivity, SoftDeletes;
  protected $table = 'sertifikat_generate';


  protected $fillable = [
    'kegiatan_peserta_id','kegiatan_panitia_id', 'id_kegiatan','sertifikat_get_nomor_id','sertifikat_get_nomor_peserta_id', 'nomor', 'periode','keterangan', 'created_at', 'updated_at', 'deleted_at'
  ];

  protected $allowedFilters = [
    'kegiatan_peserta_id', 'id_kegiatan', 'nomor', 'periode'
  ];

  protected $orderable = [
    'kegiatan_peserta_id', 'id_kegiatan', 'nomor', 'periode'
  ];

  public static function initialize()
  {
    return [
      'kegiatan_peserta_id' => '', 'id_kegiatan' => '', 'nomor' => '', 'periode' => ''
    ];
  }

  public static $rules = [
    'id_kegiatan' => 'required',
    'nomor' => 'required',
    'periode' => 'required',
  ];

  public function kegiatan()
  {
    return $this->belongsTo(Kegiatan::class, 'id_kegiatan', 'id')->select('id', 'name');
  }

  public function peserta()
  {
    return $this->belongsTo(KegiatanPeserta::class, 'kegiatan_peserta_id', 'id');
  }
  public function panitia()
  {
    return $this->belongsTo(KegiatanPanitia::class, 'kegiatan_panitia_id', 'id');
  }

  public function sertifikatGetNomor(){
    return $this->belongsTo(SertifikatGetNomor::class, 'sertifikat_get_nomor_id', 'id');
  }
  public function pesertaNonAktivis()
{
    return $this->belongsTo(SertifikatGetNomorPeserta::class, 'sertifikat_get_nomor_peserta_id');
}


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
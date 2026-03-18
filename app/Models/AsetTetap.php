<?php

namespace App\Models;

use App\Models\Aktivis;
use App\Models\AsetTetap;
use App\Models\AsetTetapGolongan;
use App\Models\AsetTetapJenis;
use App\Models\AsetTetapKelompok;
use App\Models\AsetTetapLokasi;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class AsetTetap extends BaseEloquent
{

    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'aset_tetap';

    public static $rules = [
        'name' => 'required',
        'kode' => 'sometimes|required|unique:aset_tetap',
        'aset_tetap_golongan_id' => 'required',
        'aset_tetap_kelompok_id' => 'required',
        'aset_tetap_jenis_id' => 'required',
        'aset_tetap_lokasi_id' => 'required',
        'aktivis_id' => 'required',
        'aktivis_id_pembeli' => 'required',
        'merk' => 'required',
        'tipe' => 'required',
        'kondisi' => 'required',
        'tanggal' => 'required',
        'harga' => 'required',
    ];

    public static function boot()
    {
        parent::boot();
    }

    protected $fillable = [
        'aset_id', 'aktivis_id', 'kode', 'name', 'aset_tetap_golongan_id', 'aset_tetap_kelompok_id', 'aset_tetap_jenis_id', 'merk', 'tipe', 'aset_tetap_lokasi_id', 'kondisi', 'gambar', 'aktivis_id_pembeli', 'tanggal', 'harga', 'pokok_penyusutan', 'bulan_penyusutan', 'sisa_penyusutan', 'nota', 'keterangan', 'sisa_bulan_penyusutan',
    ];

    protected $allowedFilters = [
        'aset_id', 'aktivis_id', 'kode', 'name', 'aset_tetap_golongan_id', 'aset_tetap_kelompok_id', 'aset_tetap_jenis_id', 'merk', 'tipe', 'aset_tetap_lokasi_id', 'kondisi', 'gambar', 'created_at', 'updated_at', 'hapus_dari_laporan', 'aktivis_id_pembeli', 'tanggal', 'harga', 'pokok_penyusutan', 'bulan_penyusutan', 'sisa_penyusutan', 'nota', 'keterangan', 'sisa_bulan_penyusutan',

        'aktivis.name', 'golongan.name', 'kelompok.name', 'jenis.name', 'lokasi.name', 'pembeli.name'
    ];

    protected $orderable = [
        'aset_id', 'aktivis_id', 'kode', 'name', 'aset_tetap_golongan_id', 'aset_tetap_kelompok_id', 'aset_tetap_jenis_id', 'merk', 'tipe', 'aset_tetap_lokasi_id', 'kondisi', 'gambar', 'created_at', 'updated_at', 'hapus_dari_laporan',  'aktivis_id_pembeli', 'tanggal', 'harga', 'pokok_penyusutan', 'bulan_penyusutan', 'sisa_penyusutan', 'nota', 'keterangan', 'sisa_bulan_penyusutan',
    ];

    public static function initialize()
    {
        return [
            'aset_id' => '', 'aktivis_id' => '', 'kode' => '', 'name' => '', 'aset_tetap_golongan_id' => '', 'aset_tetap_kelompok_id' => '', 'aset_tetap_jenis_id' => '', 'merk' => '', 'tipe' => '', 'aset_tetap_lokasi_id' => '', 'kondisi' => '', 'gambar' => '', 'aktivis_id_pembeli' => '', 'tanggal' => '', 'harga' => '', 'pokok_penyusutan' => '', 'bulan_penyusutan' => '', 'sisa_penyusutan' => '', 'nota' => '', 'keterangan' => '', 'sisa_bulan_penyusutan' => '',
        ];
    }

    public function aset()
    {
        return $this->belongsTo(AsetTetap::class, 'aset_id', 'id');
    }

    public function hasAset()
    {
        return $this->hasMany(AsetTetap::class, 'aset_id', 'id');
    }

    public function aktivis()
    {
        return $this->belongsTo(Aktivis::class, 'aktivis_id', 'id');
    }

    public function pembeli()
    {
        return $this->belongsTo(Aktivis::class, 'aktivis_id_pembeli', 'id');
    }

    public function golongan()
    {
        return $this->belongsTo(AsetTetapGolongan::class, 'aset_tetap_golongan_id', 'id');
    }

    public function kelompok()
    {
        return $this->belongsTo(AsetTetapKelompok::class, 'aset_tetap_kelompok_id', 'id');
    }

    public function jenis()
    {
        return $this->belongsTo(AsetTetapJenis::class, 'aset_tetap_jenis_id', 'id');
    }

    public function lokasi()
    {
        return $this->belongsTo(AsetTetapLokasi::class, 'aset_tetap_lokasi_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
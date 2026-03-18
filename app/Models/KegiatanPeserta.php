<?php

namespace App\Models;

use App\Models\Aktivis;
use App\Models\Kegiatan;
use App\Models\MitraOrang;
use App\Models\SertifikatGenerate;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;

class KegiatanPeserta extends Model
{

    use LogsActivity, Dataviewer;

    protected $table = 'kegiatan_peserta';

    protected $fillable = [
        'aktivis_id', 'kegiatan_id', 'mitra_orang_id', 'anggota_cu_cu_id',
        'lembaga_id', 'keterangan', 'keteranganBatal', 'ukuran_baju', 'surat_tugas',
        'status_kepesertaan', 'penerimaan_vaksin', 'merokok', 'sakit_jantung',
        'riwayat_penyakit', 'alergi_makanan',
        'status', 'name_nametag', 'name_sertifikat', 'datang', 'pulang',
        'tanggal_hadir', 'kegiatan_tipe',
        'kegiatan_name',
        'tempat', 'penyelenggara',
        'lembaga_name', 'pekerjaan_name', 'pekerjaan_tingkat',
        'pendidikan_tingkat', 'pendidikan_name',
        'created_at', 'updated_at',
    ];

    protected $allowedFilters = [
        'name_nametag', 'name_sertifikat', 'datang', 'pulang', 'status', 'kegiatan_name', 'tempat', 'lembaga_name', 'pekerjaan_name', 'pekerjaan_tingkat', 'tanggal_hadir', 'created_at', 'updated_at', 'kegiatan_tipe', 'kegiatan_name', 'pendidikan_name', 'pendidikan_tingkat', 'penyelenggara'
    ];

    protected $orderable = [
        'name_nametag', 'name_sertifikat', 'datang', 'pulang', 'status', 'kegiatan_name', 'tempat', 'lembaga_name', 'pekerjaan_name', 'pekerjaan_tingkat', 'tanggal_hadir', 'created_at', 'updated_at', 'kegiatan_tipe', 'kegiatan_name',
        'pendidikan_name', 'pendidikan_tingkat', 'penyelenggara'
    ];

    public static function initialize()
    {
        return [
            'name' => '', 'tempat' => '',
            'lembaga_name' => '', 'datang' => '',
            'pulang' => '', 'tanggal_hadir' => '',
        ];
    }

    public function aktivis()
    {
        return $this->belongsTo(Aktivis::class, 'aktivis_id', 'id');
    }

    public function mitra_orang()
    {
        return $this->belongsTo(MitraOrang::class, 'mitra_orang_id', 'id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'id');
    }

    public function sertifikat_generate(){
        return $this->hasOne(SertifikatGenerate::class, 'kegiatan_peserta_id','id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
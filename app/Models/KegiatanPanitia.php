<?php
namespace App\Models;

use App\Models\Aktivis;
use App\Models\Kegiatan;
use App\Models\MitraLembaga;
use App\Models\MitraOrang;
use Illuminate\Database\Eloquent\Model;

class KegiatanPanitia extends Model {

    protected $table = 'kegiatan_panitia';
    
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class,'kegiatan_id','id');
    }

    public function aktivis()
    {
        return $this->belongsTo(Aktivis::class,'aktivis_id','id');
    }
    
    public function mitra_orang()
    {
        return $this->belongsTo(MitraOrang::class,'aktivis_id','id');
    }

    public function mitra_lembaga()
    {
        return $this->belongsTo(MitraLembaga::class,'aktivis_id','id');
    }

}
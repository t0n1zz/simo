<?php
namespace App\Models;

use illuminate\Database\Eloquent\Model;

class KegiatanPanitia extends Model {

    protected $table = 'kegiatan_panitia';
    
    public function kegiatan()
    {
        return $this->belongsTo('App\Models\Kegiatan','kegiatan_id','id');
    }

    public function aktivis()
    {
        return $this->belongsTo('App\Models\Aktivis','aktivis_id','id');
    }
    
    public function mitra_orang()
    {
        return $this->belongsTo('App\Models\MitraOrang','aktivis_id','id');
    }

    public function mitra_lembaga()
    {
        return $this->belongsTo('App\Models\MitraLembaga','aktivis_id','id');
    }

}
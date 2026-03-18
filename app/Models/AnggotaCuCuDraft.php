<?php
namespace App\Models;

use App\Models\AnggotaCuCu;
use App\Models\AnggotaCuDraft;
use App\Models\AnggotaProdukCuDraft;
use App\Models\Cu;
use App\Models\Tp;
use Illuminate\Database\Eloquent\Model;

class AnggotaCuCuDraft extends Model {

    use \Awobaz\Compoships\Compoships;
    
    protected $table = 'anggota_cu_cu_draft';
    
    protected $fillable = [
        'anggota_cu_id','anggota_cu_draft_id','cu_id','tp_id','no_ba', 'tanggal_masuk','keterangan_masuk', 'tanggal_keluar', 'keterangan_keluar','escete'
    ];

    public function anggotaCu()
    {
        return $this->belongsTo(AnggotaCuDraft::class,'anggota_cu_draft_id','id');
    }

    public function cu()
    {
        return $this->belongsTo(Cu::class,'cu_id','id');
    }

    public function tp()
    {
        return $this->belongsTo(Tp::class,'tp_id','id');
    }

    public function rekening(){
        return $this->hasMany(AnggotaProdukCuDraft::class,'no_ba','no_ba');
    }
    
    public function anggota(){
        return $this->hasOne(AnggotaCuCu::class,['no_ba','cu_id'],['no_ba','cu_id'])->select('no_ba','id','keterangan_masuk','cu_id');
    }
    
    public function sp(){
        return $this->hasOne('App\ProdukCU','id_cu','cu_id')->where('tipe','Simpanan Pokok')->select('id_cu','id');
    }
    

}
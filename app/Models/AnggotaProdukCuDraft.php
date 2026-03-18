<?php
namespace App\Models;

use App\Models\AnggotaCu;
use App\Models\AnggotaProdukCu;
use App\Models\Cu;
use App\Models\ProdukCu;
use App\Support\Dataviewer;
use Illuminate\Database\Eloquent\Model;

class AnggotaProdukCuDraft extends Model {

    use Dataviewer;
    use \Awobaz\Compoships\Compoships;

    protected $table = 'anggota_produk_cu_draft';

    protected $fillable = [
        'id_cu','no_ba','no_rek', 'anggota_cu_id','anggota_cu_cu_id','produk_cu_id', 'saldo', 'tanggal_buka', 'tanggal_transaksi', 'lama_pinjaman','lama_sisa_pinjaman', 'tujuan', 'tanggal_target','dpd','kolekbi','tanggal_bayar_akhir'
    ];

    protected $allowedFilters = [
        'id_cu','no_ba','no_rek', 'anggota_cu_id','produk_cu_id', 'saldo', 'tanggal_buka', 'tanggal_transaksi', 'lama_pinjaman', 'tujuan', 'tanggal_target',

        'anggota_cu.name', 'anggota_cu.nik'
    ];

    protected $orderable = [
        'id_cu','no_ba','no_rek', 'anggota_cu_id','produk_cu_id', 'saldo', 'tanggal_buka', 'tanggal_transaksi', 'lama_pinjaman', 'tujuan', 'tanggal_target',
    ];

    public function cu()
    {
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','no_ba','name');
    }

    public function anggota_cu()
    {
        return $this->belongsTo(AnggotaCu::class,'anggota_cu_id','id')->select('id','name','nik');
    }

    public function produk_cu()
    {
        return $this->belongsTo(ProdukCu::class,'produk_cu_id','id')->select('id','name','id_cu','tipe');
    }

    public function anggota_produk_cu(){
        return $this->hasOne(AnggotaProdukCu::class,['no_rek','produk_cu_id'],['no_rek','produk_cu_id'])->select('no_rek','produk_cu_id','id','saldo');
    }

}
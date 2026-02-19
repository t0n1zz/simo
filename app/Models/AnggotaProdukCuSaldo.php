<?php
namespace App\Models;

use Spatie\Activitylog\LogOptions;
use illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Dataviewer;
use Spatie\Activitylog\Traits\LogsActivity;

class AnggotaProdukCuSaldo extends BaseEloquent {

    use Dataviewer, LogsActivity, SoftDeletes;

    protected $table = 'anggota_produk_cu_saldo';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'anggota_produk_cu_saldo_id','saldo'
    ];

    protected $filter = [
        'anggota_produk_cu_saldo_id','saldo'
    ];

    public static function initialize()
    {
        return [
            'anggota_produk_cu_saldo_id' => '','saldo' => ''
        ];
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
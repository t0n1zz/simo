<?php
namespace App\Models;

use App\Support\Dataviewer;
use Illuminate\Database\Eloquent\Model;

class AnggotaCuDraftFailed extends Model {
    
    use Dataviewer;

    protected $table = 'anggota_cu_draft_failed';
    
    public static function boot()
    {
        parent::boot();
    }
    
    protected $fillable = [
        'nik','name','no_ba','no_tp','no_cu','tipe'
    ];

    protected $allowedFilters = [
        'nik','name','no_ba','no_tp','no_cu','tipe'
    ];

    protected $orderable = [
        'nik','name','no_ba','no_tp','no_cu','tipe'
    ];
}
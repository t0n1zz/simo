<?php
namespace App\Models;

use App\Models\Pemilihan;
use App\Models\PemilihanCalon;
use App\Models\PemilihanCalonCount;
use App\Models\PemilihanSuaraAkses;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Support\Dataviewer;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemilihanSuara extends Model {

    use LogsActivity, Dataviewer, SoftDeletes;

    protected $table = 'pemilihan_suara';


    protected $fillable = [
        'pemilihan_id','pemilihan_calon_id','name','created_at','updated_at'
    ];

    protected $allowedFilters = [
        'id','pemilihan_id','pemilihan_calon_id','name','created_at','updated_at',
        'user.username'
    ];

    protected $orderable = [
        'id','pemilihan_id','pemilihan_calon_id','name','created_at','updated_at',
        'user.username'
    ];

    public static function initialize()
    {
        return [
            'pemilihan_id' => '','pemilihan_calon_id' => '','name' => ''
        ];
    }

    public function pemilihan()
    {
        return $this->belongsTo(Pemilihan::class,'pemilihan_id','id');
    }

    public function calon()
    {
        return $this->belongsTo(PemilihanCalon::class,'pemilihan_calon_id','id');
    }

    public function calon_count(){
        return $this->hasMany(PemilihanCalonCount::class,'pemilihan_suara_id','id');
    }

    public function akses()
    {
        return $this->belongsTo(PemilihanSuaraAkses::class,'id','pemilihan_suara_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
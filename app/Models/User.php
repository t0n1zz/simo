<?php

namespace App\Models;

use App\Models\Aktivis;
use App\Models\Cu;
use App\Models\Pus;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

use App\Support\Dataviewer;
use App\Support\ExposePermissions;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Yadahan\AuthenticationLog\AuthenticationLogable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, Notifiable, Dataviewer, ExposePermissions, LogsActivity, AuthenticationLogable, SoftDeletes;

    protected $table = 'users';
    protected $guard_name = 'api';
    protected static $logAttributes = ['id_pus','id_cu','id_aktivis','name', 'email', 'username','status','gambar'];
    protected static $ignoreChangedAttributes = ['login','updated_at'];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['can'];

    public static $rules = [
        'id_pus' => 'required',
        'id_cu' => 'required',
        'id_aktivis' => 'required',
        'username' => 'sometimes|required|unique:users',
        'password' => 'required|min:5',
    ];

    protected $fillable = [
        'id_pus','id_cu','id_aktivis','name','email','username', 'password','gambar','status','login','isChangePassword'
    ];

    protected $allowedFilters = [
        'id','id_cu','id_pus','id_aktivis','name','email','username','gambar','status','created_at','updated_at','login'
    ];

    protected $orderable = [
        'id','id_cu','id_pus','id_aktivis','name','email','username','gambar','status','created_at','updated_at','login'
    ];

    public static function initialize()
    {
        return [
            'id_aktivis' => '' ,'id_cu' => '', 'id_pus' => '1', 'name' => '','email' => '', 'username' => '', 'status' => '1', 'gambar' => ''
        ];
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

     // Rest omitted for brevity

    /**
     * Get the options for logging activity.
     */
    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logOnly($this::$logAttributes)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getId(){
        return $this->id;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getIdCu()
    {
        return $this->id_cu;
    }

    public function pus(){
        return $this->belongsTo(Pus::class,'id_pus','id')->select('id','name');
    }

    public function cu(){
        return $this->belongsTo(Cu::class,'id_cu','id')->select('id','name');
    }

    public function aktivis(){
        return $this->belongsTo(Aktivis::class,'id_aktivis','id')->select('id','name','gambar');
    }

    public function Role(){
        return $this->belongsTo('Spatie\Permission\Models\Role','id_cu','id')->select('id','name');
    }
}

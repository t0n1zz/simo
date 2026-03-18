<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suku extends Model {
    
    protected $table = 'suku';

    
    public static $rules = [
        'name' => 'required',
    ];
    
    protected $fillable = ['name'];

    protected $filter = [
        'id','name'
    ];

    public function getNameAttribute($value){
        return !empty($value) ? $value : '-';
    }

    public static function initialize(){
        return [
            'id' => '0', 'name' => ''
        ];
    }
}
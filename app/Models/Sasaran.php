<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sasaran extends Model {

    protected $table = 'sasaran';

    protected $fillable = [
       'name','deskripsi','created_at','updated_at'
    ];
}
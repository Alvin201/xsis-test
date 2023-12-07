<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ModelMovie extends Model
{

    protected $fillable = [
       'title','description','rating','image'
    ];

    public $table = 'tb_movie';
    public $timestamps  = true;
    protected $primaryKey = 'id';
}

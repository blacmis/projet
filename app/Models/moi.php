<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class moi extends Model
{   
    protected $table ='mois';
    protected $fillable = ['name','category','slug'];
}

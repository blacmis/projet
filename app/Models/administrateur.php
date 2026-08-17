<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class administrateur extends Model
{
    protected $table = 'administrateurs';
    protected $fillable = ['name','category','code admin','prenom',  ];
}

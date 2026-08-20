<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class session extends Model
{
    protected $table ='sessions';
    protected $fillable = ['id','user_id','ip_address','user_agent','payload','last_activity'];
}

<?php

namespace App\Models;

use App\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use BelongsToTenant;

    protected $table = 'feedbacks';

    protected $fillable = ['sent_by', 'type', 'message', 'status'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
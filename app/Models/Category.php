<?php
namespace App\Models;

use App\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'name',
        'description',
        'color',
    ];
    public function products()
    {
        return $this->hasMany(Product::class, 'category', 'name');
        // si plus tard tu passes en category_id, on changera cette relation
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id','name','slug','price','stock','thumbnail',
        'short_description','description','is_active',
    ];

    public function category() { return $this->belongsTo(Category::class); }
}

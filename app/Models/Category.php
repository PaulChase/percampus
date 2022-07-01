<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    const PRODUCTS_CATEGORY = 2;
    const SERVICES_CATEGORY = 4;

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function posts()
    {
        return $this->hasManyThrough(Post::class, SubCategory::class, 'category_id', 'subcategory_id');
    }

   
}

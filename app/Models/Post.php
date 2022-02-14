<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Post extends Model implements Viewable
{
    use HasFactory, Sluggable, InteractsWithViews;

    /*
    creating relatioship b/w the post and user that added it.  The function means that a post belongs to a particular user

    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alias_user_campus()
    {
        return $this->belongsTo(Campus::class, 'alias_campus');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    

    // for generating dynamic slug
    public function Sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'separator' => '-',
                'unique' => true,
                'onUpdate' => true,
                'includeTrashed' => false
            ]
        ];
    }

    // public function incrementViewCount() {
    //     $this->view_count++;
    //     return $this->save();
    // }

    public function incrementContactCount() {
        $this->no_of_contacts++;
        return $this->save();
}
}

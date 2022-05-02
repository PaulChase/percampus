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

    protected $guarded = ['id', 'created_at'];

    /*
    creating relatioship b/w the post and user that added it.  The function means that a post belongs to a particular user

    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relationship for the user added by the admin
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

    public function postViews()
    {
        return $this->hasMany(PostView::class, 'viewable_id');
    }



    

    // for generating dynamic slug
    public function Sluggable(): array
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

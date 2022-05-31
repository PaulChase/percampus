<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    const UNIVERSITY = 1;
    const STATE = 2;
    const POLYTHECHNIC = 3;
    const COLLEGE_OF_EDU = 2;

    protected $guarded = [];
  


    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    public function posts()
    {
        return $this->hasManyThrough(Post::class, User::class);
    }

    public function alias_posts()
    {
        return $this->hasMany(Post::class, 'alias_campus');
    }
}

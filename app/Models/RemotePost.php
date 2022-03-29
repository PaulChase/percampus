<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemotePost extends Model
{
    use HasFactory;

    protected $connection = 'remote_db';

    protected $table = 'posts';

    public function images()
    {
        return $this->setConnection('remote_db')->hasMany(RemoteImages::class, 'post_id');
    }

    public function user()
    {
        return $this->setConnection('remote_db')->belongsTo(RemoteUser::class, 'user_id');
    }

    public function subcategory()
    {
        return $this->setConnection('remote_db')->belongsTo(RemoteSubCategory::class, 'subcategory_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemoteSubCategory extends Model
{
    use HasFactory;

    protected $connection = 'remote_db';

    protected $table = 'sub_categories';
}

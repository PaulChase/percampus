<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemoteImages extends Model
{
    use HasFactory;

    protected $connection = 'remote_db';

    protected $table = 'images';
}

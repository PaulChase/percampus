<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemoteCampus extends Model
{
    use HasFactory;

    protected $connection = 'remote_db';

    protected $table = 'campuses';
}

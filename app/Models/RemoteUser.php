<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemoteUser extends Model
{
    use HasFactory;

    protected $connection = 'remote_db';

    protected $table = 'users';

    public function campus()
    {
        return $this->setConnection('remote_db')->belongsTo(Campus::class);
    }
}

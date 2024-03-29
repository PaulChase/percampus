<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    use HasFactory;

    public function incrementAdClick()
    {
        $this->linkClick++;
        return $this->save();
    }
}

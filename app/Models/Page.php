<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    function author() {
        return $this->hasOne('App\Models\User', 'id', 'author_id');
    }
}

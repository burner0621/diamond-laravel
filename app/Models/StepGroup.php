<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StepGroup extends Model
{
    protected $fillable = [
        'name', 'description', 'steps'
    ];
}

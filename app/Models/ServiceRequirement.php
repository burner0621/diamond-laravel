<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRequirement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_id',
        'question',
        'type',
        'required',
    ];

    public function choices()
    {
        return $this->hasMany(ServiceRequirementChoice::class, 'requirement_id', 'id')->withTrashed();
    }
}
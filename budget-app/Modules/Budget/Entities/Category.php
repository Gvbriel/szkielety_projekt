<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_id',
        'color'
    ];

    protected static function newFactory()
    {
        return \Modules\Budget\Database\factories\CategoryFactory::new();
    }
}

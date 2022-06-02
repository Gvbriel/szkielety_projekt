<?php

namespace Modules\Budget\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url'
    ];

    protected static function newFactory()
    {
        return \Modules\Budget\Database\factories\ImageFactory::new();
    }
}

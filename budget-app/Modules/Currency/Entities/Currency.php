<?php

namespace Modules\Currency\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency',
        'name'
    ];

    protected static function newFactory()
    {
        return \Modules\Currency\Database\factories\CurrencyFactory::new();
    }
}

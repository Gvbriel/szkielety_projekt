<?php

namespace Modules\Savings\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Saving extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'currency',
        'goal_id',
        'user_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Savings\Database\factories\SavingFactory::new();
    }

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function goal()
    {
        return $this->hasOne(Goal::class, 'id', 'goal_id');
    }
}

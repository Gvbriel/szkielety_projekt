<?php

namespace Modules\Savings\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'goal',
        'description',
        'currency',
        'balance',
        'user_id',
    ];

    protected static function newFactory()
    {
        return \Modules\Savings\Database\factories\GoalFactory::new();
    }

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function savings()
    {
        return $this->hasMany(Saving::class);
    }

    public function setIsFinishedAttribute()
    {
        if($this->balance >= $this->amount)
        {
            $this->attributes['is_finished'] = true;
        }
        else
        {
            $this->attributes['is_finished'] = false;
        }
    }

    public function calculateBalance()
    {
        $savings = $this->savings;
        $balance = 0;
        foreach($savings as $sav)
        {
            $balance += $sav->amount;
        }
        $this->balance = $balance;
        $this->save();
    }
}

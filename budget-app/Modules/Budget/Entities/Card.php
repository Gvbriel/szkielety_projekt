<?php

namespace Modules\Budget\Entities;

use App\Models\User;
use Modules\Budget\Entities\Budget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory;

//    use SoftDeletes;

    protected $table = "cards";

    protected $fillable = [
        'name',
        'number',
        'type',
        'balance',
        'owner_id',
        'image_id',
        'initial_balance'
    ];

    public function budget() {
        return $this->hasMany(Budget::class);
    }

    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function calculateBalance()
    {
        $balance = 0 + $this->initial_balance;
        $budgets = Budget::where('user_id', $this->owner_id)->where('card_id', $this->id)->get();
        foreach ($budgets as $budget) {
            if ($budget->type == 'Income') {
                $balance += $budget->amount;
            } else {
                $balance -= $budget->amount;
            }
        }
        $this->balance = $balance;
        $this->save();
    }

    public function setCardBalanceAttribute()
    {
        $balance = 0 + $this->initial_balance;
        $budgets = Budget::where('user_id', $this->owner_id)->where('card_id', $this->id)->get();
        foreach ($budgets as $budget) {
            if ($budget->type == 'Income') {
                $balance += $budget->amount;
            } else {
                $balance -= $budget->amount;
            }
        }
        $this->balance = $balance;
        $this->save();

        return $balance;
    }

}

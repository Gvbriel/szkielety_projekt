<?php

namespace Modules\Budget\Entities;

use App\Models\User;
use Modules\Budget\Entities\Card;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;
//    use SoftDeletes;

    protected $fillable = [
        'amount',
        'date',
        'type',
        'description',
        'title',
        'is_recurring',
        'user_id',
        'card_id',
        'category_id',
    ];

    public function card()
    {
        return $this->hasOne(Card::class, 'id', 'card_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}

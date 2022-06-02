<?php

namespace Modules\Budget\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => ucfirst($this->title),
            'description' => $this->description,
            'category' => $this->category ? $this->category->name : "Unsigned",
            'category_id' => $this->category ? $this->category->id : -1,
            'is_recurring' => $this->is_recurring,
            'is_expanded' => false,
            'tooltip' => false,
            'amount' => $this->amount,
            'type' => ucfirst($this->type),
            'date' => $this->date,
            'card' => $this->card ? new CardResource($this->card) : 0,
            'card_id' => $this->card_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}

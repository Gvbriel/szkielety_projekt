<?php

namespace Modules\Savings\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class GoalResource extends JsonResource
{
    public function toArray($request){
        $this->calculateBalance();
        $this->setIsFinishedAttribute();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'balance' => $this->balance,
            'goal' => $this->goal,
            'description' => $this->description,
            'is_finished' => $this->is_finished,
            'is_active' => false,
            'chart_value' => round((100*$this->balance)/$this->goal),
            'currency' => $this->currency,
            'savings_count' => $this->savings->count(),
            'savings' => $this->savings,
            'created_at' => $this->created_at,
        ];
    }

}

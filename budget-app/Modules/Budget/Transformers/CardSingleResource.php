<?php

namespace Modules\Budget\Transformers;

use Modules\Budget\Http\Controllers\ResponseHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Budget\Entities\Budget;
use Modules\Budget\Transformers\BudgetResource;

class CardSingleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'number' => $this->number,
            'balance' => $this->setCardBalanceAttribute(),
            'type' => ucfirst($this->type),
            'image' => $this->image ? $this->image->url : 0,
            'budgets' => ResponseHelper::getPagination(BudgetResource::collection(Budget::where('card_id', $this->id)->paginate()))
        ];
    }
}

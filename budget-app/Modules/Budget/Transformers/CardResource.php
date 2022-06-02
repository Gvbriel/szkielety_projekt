<?php


namespace Modules\Budget\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    public function toArray($request)
    {
        $this->calculateBalance();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'number' => $this->number,
            'balance' => $this->setCardBalanceAttribute(),
            'type' => ucfirst($this->type),
            'image' => $this->image ? $this->image->url : 0,
        ];
    }
}

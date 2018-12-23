<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MealResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'state' => $this->state,
            'table_number' => $this->table_number,
            'start' => $this->start,
            'end' => $this->end,
            'responsible_waiter_id' => $this->responsible_waiter_id,
            'total_price_preview' => $this->total_price_preview,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

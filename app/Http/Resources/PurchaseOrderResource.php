<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderResource extends JsonResource
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
            'uuid' => $this->uuid,
            'customer_id' => $this->customer_id,
            'purchase_order_history_status_id' => $this->purchase_order_history_status_id,
            'arrival_date' => $this->arrival_date,
            'last_modified' => $this->last_modified,
            'customer_reference' => $this->customer_reference,
            'PurchaseOrderHistoryStatus' => $this->PurchaseOrderHistoryStatus,
            'PurchaseOrderProducts' => PurchaseOrderProductResource::collection($this->PurchaseOrderProduct),
        ];
    }
}

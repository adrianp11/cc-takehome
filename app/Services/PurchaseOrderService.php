<?php

namespace App\Services;

use App\Http\Resources\PurchaseOrderResource;
use Illuminate\Support\Facades\Http;

class PurchaseOrderService
{
    /**
     * The calculation methods for each product type.
     */
    protected $calculationMethods = [
        1 => 'calculateByWeight',
        2 => 'calculateByVolume',
        3 => 'calculateByWeight',
    ];

    /**
     * Calculate totals for each product type.
     *
     * @param  array $purchaseOrderIds
     * @return array
     */
    public function calculateTotals(array $purchaseOrderIds)
    {
        $responses = collect($purchaseOrderIds)->map(function ($id) {
            $response = Http::withBasicAuth(config('services.cartoncloud.username'), config('services.cartoncloud.password'))->get(config('services.cartoncloud.url') . "/CartonCloud_Demo/PurchaseOrders/" . $id . '?version=' . config('services.cartoncloud.version') . '&associated=true')->json();
            return new PurchaseOrderResource($response['data']);
        });

        $totals = [];
        foreach ($responses as $purchaseOrder) {
            foreach ($purchaseOrder->getPurchaseOrderProducts() as $product) {
                $method = $this->calculationMethods[$product['product_type_id']];
                if (!isset($totals[$product['product_type_id']])) {
                    $totals[$product['product_type_id']] = 0;
                }
                $totals[$product['product_type_id']] += $this->$method($product);
            }
        }

        return $totals;
    }

    /**
     * Calculate the total by weight.
     *
     * @param  array $product
     * @return float
     */
    protected function calculateByWeight(array $product)
    {
        return $product['unit_quantity_initial'] * $product['weight'];
    }

    /**
     * Calculate the total by volume.
     *
     * @param  array $product
     * @return float
     */
    protected function calculateByVolume(array $product)
    {
        return $product['unit_quantity_initial'] * $product['volume'];
    }
}
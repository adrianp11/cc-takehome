<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseOrderTotalsRequest;
use App\Services\PurchaseOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PurchaseOrderController extends Controller
{
    /**
     * generate purchase order totals
     *
     * @param  PurchaseOrderTotalsRequest $request
     * @param  PurchaseOrderService $service
     * @return \Illuminate\Http\Response
     */
    public function purchaseOrderTotals(PurchaseOrderTotalsRequest $request, PurchaseOrderService $service)
    {
        $result = $service->calculateTotals($request->purchase_order_ids);

        return response()->json([
            'result' => $result
        ]);
    }
}
<?php

namespace Tests\Unit;

use App\Services\PurchaseOrderService;
use PHPUnit\Framework\TestCase;

class PurchaseOrderServiceTest extends TestCase
{
    protected $purchaseOrderService;

    public function setUp(): void
    {
        parent::setUp();

        $this->purchaseOrderService = new PurchaseOrderService();
    }

    /**
     * Test calculateTotal method
     *
     * @return void
     */
    public function testCalculateTotal()
    {
        $items = [
            ['product_id' => 1, 'quantity' => 2, 'price' => 10],
            ['product_id' => 2, 'quantity' => 1, 'price' => 5],
        ];

        $total = $this->purchaseOrderService->calculateTotals($items);

        $this->assertEquals(25, $total);
    }
}
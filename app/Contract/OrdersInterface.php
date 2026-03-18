<?php

namespace App\Contract;

use App\Models\Inventory;
use Illuminate\Http\Request;

interface OrdersInterface
{
    public function createOrder( Request $request);
    public function renderPaymentGateway(float $amount , int $qty);
}

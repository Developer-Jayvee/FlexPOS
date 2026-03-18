<?php

namespace App\Services;

use App\Contract\OrdersInterface;
use App\Models\Inventory;
use App\Models\OrderItems;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OrdersServices extends Services implements OrdersInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
      //
    }
    /**
     * createOrder
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function createOrder(Request $request): JsonResponse
    {
        try {
            $data = (object) $request->all();
            $orders = $data?->orders ?: null;
            $details = $data?->details ?: null;
            $response = [ 'message' => 'Process successfully',  'link' => '',  'status'=>200 ];

            if(!$orders || !$details){
                throw new \Exception("Failed to process, Incomplete payload", 500);
            }
            DB::beginTransaction();
                $orderModel = Orders::with(['orderItems'])->create($details);
                self::saveOrderItems($orderModel,$orders);
                $response['link'] = self::renderPaymentGateway($details['grand_total'],$details['total_qty']);

            DB::commit();
            return $this->setResponse($response);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->setResponse("",500,$th->getMessage());
        }
    }

    private function saveOrderItems(Orders $order,array $items): bool
    {
        if(!$order){
            throw new \Exception("No order found", 500);
        }
        if(count($items) === 0 || !$items){
            throw new \Exception("No items found", 500);
        }
        $toStore = array();
        $itemIds = array_map(function($item){
            return $item['id'];
        },$items);

        $inventoryItems = Inventory::whereIn('id',$itemIds)->get()->keyBy('id');

        foreach ($items as $col => $value) {
            if(!$inventoryItems[$value['id']]){
                throw new \Exception("Invalid item", 500);
            }
            $details = $inventoryItems[$value['id']];
            $toStore[] = [
                'order_id' => $order->id,
                'item_id' => $details->id,
                'qty' => $value['qty'],
                'price_per_item' => 100,
                'total_price' => 200
            ];
        }
        $order->orderItems()->createMany($toStore);
        return true;
    }
    /**
     * Process payment
     *
     * @param  mixed $amount
     * @param  mixed $qty
     * @return string link
     */
    public function renderPaymentGateway(float $amount , int $qty): string
    {
        $payment = new PaymentsServices($amount,$qty);
        $response = $payment->run();
        return $response['data']['attributes']['checkout_url'];
    }
}

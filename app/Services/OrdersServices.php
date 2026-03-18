<?php

namespace App\Services;

use App\Contract\OrdersInterface;
use App\Models\OrderItems;
use App\Models\Orders;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\DB;
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
            $response = [
                'callback_url' => '',
                'status'=>200
            ];
            $data = (object) $request->all();
            $orders = $data?->orders ?: null;
            $details = $data?->details ?: null;

            if(!$orders || !$details){
                throw new \Exception("Failed to process, Incomplete payload", 500);
            }
            // DB::transaction();
                $orderModel = Orders::with(['orderItems'])->create($details);
                $itemParams = array(
                    'order_id' => $orderModel->id
                );

                self::saveOrderItems($orderModel,array_merge($orders,$itemParams));
            // DB::commit();

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
        foreach ($items as $col => $value) {
            $items['order_id'] = $order->id;

        }


        return true;
    }
    /**
     * processPayment
     *
     * @param  mixed $request
     * @return array
     */
    public function renderPaymentGateway(Request $request): array
    {

        return [
            'url' => 'link'
        ];
    }
}

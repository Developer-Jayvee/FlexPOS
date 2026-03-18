<?php

namespace App\Services;

use App\Contract\OrdersInterface;
use App\Models\OrderItems;
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
            DB::transaction(function () {

            });


            return $this->setResponse($response);
        } catch (\Throwable $th) {
            return $this->setResponse("",500,$th->getMessage());
        }
    }
    /**
     * insertOrderForm
     *
     * @param  mixed $details
     * @return Bool
     */
    private function insertOrderForm(array $details): Bool
    {
        if(count($details) === 0){
            return false;
        }

        return true;
    }
    /**
     * insertOrderItems
     *
     * @param  mixed $items
     * @return Bool
     */
    private function insertOrderItems(array $items): Bool
    {
        if(count($items) === 0){
           return false;
        }
        OrderItems::create($items);
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

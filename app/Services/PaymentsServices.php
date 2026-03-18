<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\JsonResponse;

class PaymentsServices extends Services
{
    protected float $amount;
    protected int $quantity;
    protected string $name = "FlexPOS";
    protected string $apiClient;
    private array $tokenDetails;
    public function __construct(float $amount , int $quantity , string $apiClient = "https://api.paymongo.com/v1/checkout_sessions" , array $tokenDetails = ['data' => 'c2tfdGVzdF9IQUFQUnJmVlZza2VHUnBtV1luOUtCd1A6' , 'type' => 'Basic'])
    {
        $this->amount = $amount;
        $this->quantity = $quantity;
        $this->apiClient = $apiClient;
        $this->tokenDetails = $tokenDetails;
    }
    /**
     * Http body
     *
     * @return array
     */
    private function body(): array
    {
        return [
            'data' => [
                'attributes' => [
                    'send_email' => false,
                    'show_description' => true,
                    'show_line_items' => true,
                    'line_items' =>  [
                        [
                            'currency' => 'PHP',
                            'amount' => $this->amount,
                            'name' => $this->name,
                            'quantity' => $this->quantity
                        ]
                    ],
                    'payment_method_types' => ['gcash']
                ]
            ]
        ];
    }

    private function setupClient()
    {
        $client = Http::accept("application/json")
                    ->withToken(
                        $this?->tokenDetails['data'],
                        $this->tokenDetails['type'] ?: 'Bearer'
                    );

        return $client->post('https://api.paymongo.com/v1/checkout_sessions',self::body());
    }

    /**
     * Execute http client
     *
     * @return array
     */
    public function run(): array
    {
        try {
            $response = Cache::remember('payment-gateway',60*5,function(){
                $response = self::setupClient();
                return $response->json();
            });

            return $response;
        } catch (\Throwable $th) {
            return [
                'error' =>$th->getMessage()
            ];
        }
    }
}

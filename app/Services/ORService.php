<?php

namespace App\Services;

use App\Contract\ORInterface;
use App\Models\ORCounters;
use App\Models\ORFormat;
use Symfony\Component\HttpFoundation\JsonResponse;

class ORService extends Services implements ORInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * getORNo
     *
     * @param  bool $increment
     * @return JsonResponse
     */
    public function generateORNo(bool $increment = false): JsonResponse
    {
        try {
            $currentCount = ORCounters::with('orFormat')->first();
            $orCount =  $currentCount->or_count;
            if($increment){
                $currentCount->or_count += 1;
                $currentCount->save();
            }
            $currentCount->orFormat->or_no_format = $orCount;
            return $this->setResponse([
                 'orNo' => $currentCount->orFormat->or_no_format
            ]);

        } catch (\Throwable $th) {
            return $this->setResponse("",500,$th->getMessage());
        }
    }

}

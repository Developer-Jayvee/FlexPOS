<?php

namespace App\Http\Controllers;

use App\Contract\ORInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ORController extends Controller
{
    protected $orService;
    /**
     * __construct
     *
     * @param  mixed $orService
     * @return void
     */
    public function __construct(ORInterface $orService) {
        $this->orService = $orService;
    }

    /**
     * getORNo
     *
     * @return JsonResponse
     */
    public function getORNo():JsonResponse
    {
        return $this->orService->generateORNo();
    }
    /**
     * createNewOR
     *
     * @return JsonResponse
     */
    public function createNewOR():JsonResponse
    {
        return $this->orService->generateORNo(true);
    }
}

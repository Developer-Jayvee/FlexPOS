<?php

namespace App\Services;

use App\Contract\InventoryInterface;
use App\Http\Resources\InventoryResource;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\JsonResponse;

use Illuminate\Support\Facades\DB;

class InventoryServices extends Services implements InventoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    /**
     * displayInventory
     *
     * @return JsonResponse
     */
    public function displayInventory(): JsonResponse
    {
        try {
            $data = Cache::remember('inventory-list',60, function(){
                return Inventory::paginate(10);
            });
            return $this->setResponse($data,200);
        } catch (\Throwable $th) {
            return $this->setResponse($th->getMessage() , $th->getCode());
        }
    }

    /**
     * createNewItem
     *
     * @param  mixed $request
     * @return JsonResponse
     */
    public function createNewItem(Request $request): JsonResponse
    {
        try {
            DB::transaction(function ()  use($request){
               $data =  Inventory::create($request->all());
            });
            return $this->setResponse('Successfully inserted new item in inventory',200);
        } catch (\Throwable $th) {
            return $this->setResponse([] ,500 , $th->getMessage());
        }
    }
    /**
     * updateItem
     *
     * @param  mixed $request
     * @param  mixed $inventory
     * @return JsonResponse
     */
    public function updateItem(Request $request , Inventory $inventory): JsonResponse
    {
        try {
            if(!$inventory){
                throw new \Exception("Item does not exist", 500);
            }
            $inventory->update(
                $request->all()
            );
            return $this->setResponse("Successfully Updated",200);
        } catch (\Throwable $th) {
            return $this->setResponse([] ,500 , $th->getMessage());
        }
    }

    /**
     * deleteItem
     *
     * @param  mixed $inventory
     * @return JsonResponse
     */
    public function deleteItem(Inventory $inventory):JsonResponse
    {
        try {
            if(!$inventory){
                throw new \Exception("Item does not exist",500);
            }
            $inventory->delete();
            return $this->setResponse('Successfully deleted item');
        } catch (\Throwable $th) {
            return $this->setResponse([] ,500 , $th->getMessage());
        }
    }

    /**
     * getItem
     *
     * @param  mixed $id
     * @return JsonResponse
     */
    public function getItem(int $id):JsonResponse
    {
        try {
            $item = Inventory::find($id);
            return $this->setResponse($item,200);
        } catch (\Throwable $th) {
            return $this->setResponse([] ,500 , $th->getMessage());
        }
    }



}

<?php

namespace App\Contract;

use App\Models\Inventory;
use Illuminate\Http\Request;

interface InventoryInterface
{
    public function displayInventory();
    public function createNewItem(Request $request);
    public function getItem(int $id);
    public function deleteItem(Inventory $inventory);
    public function updateItem(Request $request , Inventory $inventory);
}

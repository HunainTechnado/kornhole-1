<?php

/** @noinspection PhpUnhandledExceptionInspection */

namespace App\Http\Controllers;

use App\Models\PurchasedItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchasedItemController extends Controller
{
    final public function purchaseItem(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|string',
            'item_name' => 'required|string',
            'item_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $item = $validator->validated();

        $item = new PurchasedItem($item);
        $item->owner()->associate($request->user())->save();

        return response()->json(['items' => $request->user()->purchasedItems], 200);
    }

    final public function getPurchasedItems(): JsonResponse
    {
        return response()->json(['items' => request()->user()->purchasedItems], 200);
    }
}
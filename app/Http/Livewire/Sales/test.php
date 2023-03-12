<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Employee;
use App\Exceptions\OutOfStockException;
use App\Rules\Instock;

class SalesController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $itemCount = $request->input('itemCount', 1);
        $item = $request->input('item');
        $employeeId = auth()->user()->id;

        for ($i = 1; $i <= $itemCount; $i++) {
            $validator = Validator::make($request->all(), [
                "item.{$i}.quantity" => ['required', 'numeric', 'min:1'],
                "item.{$i}.product_id" => ['required', 'exists:products,id'],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $product = Product::find($item[$i]['product_id']);

            if (!$product->inStock($item[$i]['quantity'])) {
                return response()->json(['errors' => ['item' => ['The provided quantity exceeds the stock quantity.']]], 422);
            }

            $product->decreaseStock($item[$i]['quantity']);

            Sale::create([
                'employee_id' => $employeeId,
                'quantity' => $item[$i]['quantity'],
                'product_id' => $item[$i]['product_id'],
            ]);
        }

        return response()->json(['message' => 'Record Added Successfully']);
    }

    public function update(Request $request, Sale $sale): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'quantity' => ['required', 'numeric', 'min:1'],
            'product_id' => ['required', 'exists:products,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::find($request->input('product_id'));

        if (!$product->inStock($request->input('quantity') - $sale->quantity)) {
            return response()->json(['errors' => ['item' => ['The provided quantity exceeds the stock quantity.']]], 422);
        }

        $product->decreaseStock($request->input('quantity') - $sale->quantity);
        $sale->update([
            'quantity' => $request->input('quantity'),
            'product_id' => $request->input('product_id'),
        ]);

        return response()->json(['message' => 'Record Updated Successfully']);
    }

    public function delete(Sale $sale): JsonResponse
    {
        $product = Product::find($sale->product_id);
        $product->increaseStock($sale->quantity);
        $sale->delete();

        return response()->json(['message' => 'Record Deleted Successfully']);
    }
}

<?php

namespace App\Http\Controllers\Api\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Sales\SaleResource;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortBy = $request->get('sortBy', 'id');
        $sortAsc = $request->get('sortAsc', true);
        $perPage = $request->get('perPage', 15);

        $query = Sale::query()
            ->with(['employee','product','employee.user'])
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC');

        $results = $query->paginate($perPage);

        return SaleResource::collection($results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSaleRequest $request)
    {
        $validatedData= $request->validated();
        $employeeId = auth()->user()->id;
    
            $product = Product::find($validatedData['product_id']);
    
            $product->decreaseStock($validatedData['quantity']);
    
            Sale::create([
                'employee_id' => $employeeId,
                'quantity' => $validatedData['quantity'],
                'product_id' => $validatedData['product_id'],
            ]);
        
    
        return response()->json(['message' => 'Record Added Successfully'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
        public function update(UpdateSaleRequest $request, $sale): JsonResponse
    {
    
        $product = Product::find($productId);
        $oldQuantity = $request->input('old_quantity');
    
        $product->increaseStock($oldQuantity);
    
        if (!$product->inStock($request->input('quantity'))) {
            $product->decreaseStock($oldQuantity);
            return response()->json(['error' => 'The provided quantity exceeds the stock quantity.'], 422);
        }
    
        $product->decreaseStock($request->input('quantity'));
    
      $sale = Sale::findOrFail($request->input('id'));
      $sale->quantity = $request->input('quantity');
      $sale->save();
    
        return new JsonResponse([
            'status' => 'success',
            'message' => 'Record Updated Successfully',
            'data' => new SaleResource($sale),
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Api\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
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
     //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSaleRequest $request)
    {
        $itemCount = $request->input('itemCount', 1);
        $item = $request->input('item');
        $employeeId = auth()->user()->id;
    
        for ($i = 1; $i <= $itemCount; $i++) {
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
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

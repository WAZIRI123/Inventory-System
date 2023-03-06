<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Vendor\VendorResource;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortBy = $request->input('sortBy', 'id');
        $sortAsc = $request->input('sortAsc', true);
        $search = $request->query('search', '');
        $perPage = $request->query('per_page', 15);

        $products = Product::query()
            ->with(['vendor', 'stockMutations'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            })
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC');

        $products = $products->paginate($perPage);

        return ProductResource::collection($products);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = Vendor::orderBy('name')->get();

        return VendorResource::collection($vendors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {

        $validatedData = $request->validated();

        $product = Product::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'purchase_price' => $validatedData['purchase_price'],
            'sale_price' => $validatedData['sale_price'],
            'vendor_id' => $validatedData['vendor_id'],
        ]);

        $product->increaseStock($validatedData['quantity']);

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($product),
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}

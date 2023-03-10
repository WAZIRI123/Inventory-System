<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Vendor\VendorResource;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiProductController extends Controller
{
    use AuthorizesRequests;
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

        return response()->json(['message' => 'Record Created Successfully'], 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->authorize('update',$product);

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
        $validatedData =$request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'purchase_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'vendor_id' => 'required|exists:vendors,id'
        ]);
        
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'purchase_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
            'vendor_id' => $request->vendor_id,
        ]);

        $product->setStock($request->quantity);

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Record Updated Successfully',
            'data' => new ProductResource($product),
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
 
        $this->authorize('delete', $product);
 
        $product->clearStock();
        $product->delete();

        return response()->json(['message' => 'Record Deleted Successfully'], 200);
    }
}

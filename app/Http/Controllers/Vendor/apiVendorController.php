<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\StoreVendorRequest;
use App\Http\Requests\Vendor\UpdateVendorRequest;
use App\Http\Resources\Vendor\VendorResource;
use App\Models\Vendor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class apiVendorController extends Controller
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

        $vendors = Vendor::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            })
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC');

        $vendors = $vendors->paginate($perPage);

        return VendorResource::collection($vendors);
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
    public function store(StoreVendorRequest $request)
    {
        $validatedData = $request->validated();
        $item = Vendor::create([
            'name' => $validatedData['name'],
            'contact_email' => $validatedData['contact_email'],
            'contact_phone' => $validatedData['contact_phone'],
        ]);

        return response()->json(['message' => 'Record Created Successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {

        return new VendorResource($vendor);
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
    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        $validatedData = $request->validated();
        $vendor->update([
            'name' =>$validatedData['name'],
            'contact_email' => $validatedData['contact_email'],
            'contact_phone' => $validatedData['contact_phone'],
        ]);

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Record Updated Successfully',
            'data' => new VendorResource($vendor),
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

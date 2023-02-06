<?php

namespace App\Http\Controllers;

use App\Models\ProductProduced;
use App\Http\Requests\StoreProductProducedRequest;
use App\Http\Requests\UpdateProductProducedRequest;

class ProductProducedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreProductProducedRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductProducedRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductProduced  $productProduced
     * @return \Illuminate\Http\Response
     */
    public function show(ProductProduced $productProduced)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductProduced  $productProduced
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductProduced $productProduced)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductProducedRequest  $request
     * @param  \App\Models\ProductProduced  $productProduced
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductProducedRequest $request, ProductProduced $productProduced)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductProduced  $productProduced
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductProduced $productProduced)
    {
        //
    }
}

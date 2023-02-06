<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Http\Requests\StoreStockTransactionRequest;
use App\Http\Requests\UpdateStockTransactionRequest;

class StockTransactionController extends Controller
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
     * @param  \App\Http\Requests\StoreStockTransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStockTransactionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StockTransaction  $stockTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(StockTransaction $stockTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StockTransaction  $stockTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(StockTransaction $stockTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStockTransactionRequest  $request
     * @param  \App\Models\StockTransaction  $stockTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStockTransactionRequest $request, StockTransaction $stockTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockTransaction  $stockTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockTransaction $stockTransaction)
    {
        //
    }
}

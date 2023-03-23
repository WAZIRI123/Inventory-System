<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Sales\SaleResource;
use App\Models\Sale;
use Illuminate\Http\Request;

class apiReportController extends Controller
{
    
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sortBy = $request->input('sort_by', 'id');
        $sortAsc = $request->input('sort_asc', true);

        $results = Sale::with(['employee', 'product', 'employee.user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->get();

        return SaleResource::collection($results);
    }


    public function print(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sortBy = $request->input('sort_by', 'id');
        $sortAsc = $request->input('sort_asc', true);

        $results = Sale::with(['employee', 'product', 'employee.user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->get();

        // Store results in session
        session()->put('results', $results);

        // Return response
        return response()->json(['message' => 'Results stored in session']);
    }

}

<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Resources\Sales\SaleResource;
use App\Models\Sale;
use App\Services\Print\PrintService;
use Illuminate\Http\Request;

class apiReportController extends Controller
{
    
    public function index(Request $request)
    {
        $startDate = $request->input('dateFrom');
        $endDate = $request->input('dateTo');
        $sortBy = $request->input('sort_by', 'id');
        $sortAsc = $request->input('sort_asc', true);
        $perPage = $request->get('perPage', 15);
        $query = Sale::with(['employee', 'product', 'employee.user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC');
            $results = $query->paginate($perPage);
        return SaleResource::collection($results);
    }


    public function print(Request $request)
    {
        $startDate = $request->input('dateFrom');
        $endDate = $request->input('dateTo');
        $sortBy = $request->input('sort_by', 'id');
        $sortAsc = $request->input('sort_asc', true);

        $results = Sale::with(['employee', 'product', 'employee.user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->get();

        // Store results in session
        session()->put('results', $results);
        $results=session()->get('results');
        // Return response
        return PrintService::createPdfFromView('result.pdf', 'livewire.reports.sales-pdf', ['results' => $results]);
    }

}

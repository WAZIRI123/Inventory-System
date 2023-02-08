<?php

namespace App\Http\Livewire;

use App\Models\Classes;
use App\Models\Employee;
use App\Models\Parents;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Student;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithFileUploads;
    use WithPagination;
    // public $totalRooms;

    public $totalRevenue;

    public $totalProducts;

    public $outOfStock;
    public $totalRevenueAsMchele;
    public $totalEmployees;
    
    public $latestSales;

    public function render()
    {
        $totalRevenue = Sale::join('products', 'sales.product_id', '=', 'products.id')
        ->selectRaw('SUM(products.sale_price* sales.quantity) as total_revenue')
        ->first()->total_revenue;
        $latestSales=Sale::with('product')->latest()->take(10)->get();

        $totalRevenueAsMchele = Sale::join('products', 'sales.product_id', '=', 'products.id')
        ->where('products.id',1)
        ->selectRaw('SUM(products.sale_price* sales.quantity) as totalRevenueAsMchele')
        ->first()->totalRevenueAsMchele;
        $latestSales=Sale::with('product')->latest()->take(10)->get();

        $this->latestSales= $latestSales;
        
        $this->totalProducts = Product::count();
        $this->totalEmployees = Employee::count();
        $this->totalRevenue= $totalRevenue;
        $this->totalRevenueAsMchele=$totalRevenueAsMchele;
        $this->outOfStock   =Product::whereOutOfStock()->get()->count();
        return view('livewire.index')->layoutData(['title' => 'Admin Dashboard | Inventory Management System']);
    }

}

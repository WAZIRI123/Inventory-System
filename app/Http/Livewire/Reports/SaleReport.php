<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use \Illuminate\View\View;

use App\Models\Sale;
use App\Services\Print\PrintService;

class SaleReport extends Component
{
    public $startDate=null;
    public $endDate=null;

     /**
     * @var string
     */
    public $sortBy = 'id';

    /**
     * @var bool
     */
    public $sortAsc = true;

    public function mount(): void
    {

    }
    public function getSalesProperty(){
        return $this->query()
        ->with(['employee','product','employee.user'])
        ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
        ->get();
    }


    public function render(): View
    {
        $results = $this->sales;
        return view('livewire.reports.sale-report', [
            'results' => $results
        ])->layoutData(['title' => 'Sales-Report | School Management System']);
    }

    public function print(){
    
        $results=$this->sales;
       
        session()->put('results',$results);

        
        return redirect()->route('sale-reports');

    }
    public function sortBy(string $field): void
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }
    public function query(): Builder
    {
        return Sale::query()->whereBetween('created_at', [$this->startDate, $this->endDate]);
    }


}

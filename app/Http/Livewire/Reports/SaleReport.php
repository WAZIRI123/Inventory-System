<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use \Illuminate\View\View;

use App\Models\Sale;

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

    public function render(): View
    {
        $results = $this->query()
            ->with(['employee','product','employee.user'])
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->get();

        return view('livewire.reports.sale-report', [
            'results' => $results
        ])->layoutData(['title' => 'Sales-Report | School Management System']);
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

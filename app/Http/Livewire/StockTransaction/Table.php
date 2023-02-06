<?php

namespace App\Http\Livewire\StockTransaction;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use \Illuminate\View\View;

use App\Models\StockTransaction;

class Table extends Component
{
    use WithPagination;

    /**
     * @var array
     */
    protected $listeners = ['refresh' => '$refresh'];
    /**
     * @var string
     */
    public $sortBy = 'id';

    /**
     * @var bool
     */
    public $sortAsc = true;

    /**
     * @var int
     */
    public $per_page = 15;


    public function mount(): void
    {

    }

    public function render(): View
    {
        $results = $this->query()
            ->with(['product','employee.user'])
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->paginate($this->per_page);

        return view('livewire.stock-transaction.table', [
            'results' => $results
        ])->layoutData(['title' => 'toaKwaMpishi | Inventory Management System']);
    }

    public function sortBy(string $field): void
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function query(): Builder
    {
        return StockTransaction::query();
    }
}

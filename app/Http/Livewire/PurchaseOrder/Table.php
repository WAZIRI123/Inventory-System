<?php

namespace App\Http\Livewire\PurchaseOrder;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use \Illuminate\View\View;

use App\Models\PurchaseOrder;

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
     * @var string
     */
    public $q;

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
            ->with(['vendor','items'])
            ->when($this->q, function ($query) {
                return $query->where(function ($query) {
                    $query->where('vendor_id', 'like', '%' . $this->q . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->paginate($this->per_page);

        return view('livewire.purchase-order.table', [
            'results' => $results
        ])->layoutData(['title' => 'purchase-order | School Management System']);
    }

    public function sortBy(string $field): void
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function query(): Builder
    {
        return PurchaseOrder::query();
    }
}
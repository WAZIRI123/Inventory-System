<?php

namespace App\Http\Livewire;

use App\Models\Classes;
use App\Models\Parents;
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

    public function render()
    {
        return view('livewire.index')->layoutData(['title' => 'Admin Dashboard | School Management System']);
    }

}

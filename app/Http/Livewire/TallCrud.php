<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TallCrud extends Component
{
    public function render()
    {
        return view('livewire.tall-crud')->layoutData(['title' => ' Dashboard | School Management System']);
    }
}

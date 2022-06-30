<?php

namespace App\Http\Livewire;

use App\Models\Campus;
use Livewire\Component;

class RequestItem extends Component
{
    public $campuses;
    public $name;
    public $campusId;
    public $contact;
    public $message;
    public function mount()
    {
        $this->campuses = Campus::where('type', Campus::UNIVERSITY)->orderBy('name')->get();
    }
    public function render()
    {
        return view('livewire.request-item');
    }
}

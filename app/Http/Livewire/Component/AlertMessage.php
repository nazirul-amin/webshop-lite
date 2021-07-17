<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;

class AlertMessage extends Component
{
    public $level;
    public $message;

    public function render()
    {
        return view('livewire.component.alert-message');
    }
}

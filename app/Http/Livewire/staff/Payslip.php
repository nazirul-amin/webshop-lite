<?php

namespace App\Http\Livewire\Staff;

use Livewire\Component;

class Payslip extends Component
{
    public function render(){
        $data['months'] = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $data['years'] = ['2022', '2021', '2019'];
        return view('livewire.staff.payslip', $data);
    }
}

<?php

namespace App\View\Components\backend\income;

use App\Models\TypeIncome;
use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $typeincome = TypeIncome::all();
        return view('components..backend.income.modal',compact('typeincome'));
    }
}

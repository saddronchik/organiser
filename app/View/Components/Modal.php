<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{

    public $id;
    public $size;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $size = '')
    {
        $this->id = $id;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}

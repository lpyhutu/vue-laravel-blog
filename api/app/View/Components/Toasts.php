<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Toasts extends Component
{
    public $msg;
    public $current;

    /**
     * Create a new component instance.
     *
     * @param $msg
     * @param $current
     */
    public function __construct($msg, $current)
    {
        $this->msg = $msg;
        $this->current = $current;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.toasts');
    }
}

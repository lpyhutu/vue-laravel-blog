<?php

namespace App\View\Components;

use App\Models\FrontTotal;
use Illuminate\View\Component;

class User extends Component
{
    protected $total;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->total = new FrontTotal();
    }

    public function total()
    {
        $total = $this->total->num();
        return json_encode($total["data"]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.user');
    }
}

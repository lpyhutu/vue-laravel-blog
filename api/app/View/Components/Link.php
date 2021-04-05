<?php

namespace App\View\Components;

use App\Models\FrontLink;
use Illuminate\View\Component;

class Link extends Component
{
    protected $link;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->link = new FrontLink();
    }

    public function link()
    {
        $link = $this->link->getRelease();
        return $link["data"];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.link');
    }
}

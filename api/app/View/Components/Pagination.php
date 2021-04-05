<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Pagination extends Component
{
    public $page;
    public $pageNum;
    public $route;

    /**
     * Create a new component instance.
     *
     * @param $page
     * @param $pageNum
     * @param $route
     */
    public function __construct($page, $pageNum, $route)
    {
        $this->page = $page;
        $this->pageNum = $pageNum;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.pagination');
    }
}

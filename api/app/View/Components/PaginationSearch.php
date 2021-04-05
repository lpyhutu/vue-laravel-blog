<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PaginationSearch extends Component
{
    public $page;
    public $pageNum;
    public $route;
    public $search;

    /**
     * Create a new component instance.
     *
     * @param $page
     * @param $pageNum
     * @param $route
     * @param $search
     */
    public function __construct($page, $pageNum, $route, $search)
    {
        $this->page = $page;
        $this->pageNum = $pageNum;
        $this->route = $route;
        $this->search = $search;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.pagination-search');
    }
}

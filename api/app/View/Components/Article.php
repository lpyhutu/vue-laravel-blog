<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Article extends Component
{
    public $article;
    public $pageNum;
    public $page;

    /**
     * Create a new component instance.
     *
     * @param $article
     * @param $total
     */
    public function __construct($article, $page, $pageNum)
    {
        $this->article = $article;
        $this->page = $page;
        $this->pageNum = $pageNum;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.article');
    }
}

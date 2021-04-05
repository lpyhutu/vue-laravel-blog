<?php

namespace App\View\Components;

use App\Models\FrontArticle;
use Illuminate\View\Component;

class Ranking extends Component
{
    protected $article;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->article = new FrontArticle();
    }

    public function reading()
    {
        $reading = $this->article->readingRanking();
        return $reading["data"];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.ranking');
    }
}

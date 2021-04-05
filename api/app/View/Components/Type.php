<?php

namespace App\View\Components;

use App\Models\FrontTypeArticle;
use Illuminate\View\Component;

class Type extends Component
{
    protected $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->type = new FrontTypeArticle();
    }

    public function type()
    {
        $type = $this->type->getRelease();
        return $type["data"];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.type');
    }
}

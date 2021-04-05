<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Com extends Component
{
    public $url;

    /**
     * Create a new component instance.
     * @param string $url
     * @param int $comment_id
     */
    public function __construct($url = "/")
    {
        $this->url = $url;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.com');
    }
}

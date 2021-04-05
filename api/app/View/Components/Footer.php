<?php

namespace App\View\Components;

use App\Models\FrontInfo;
use Illuminate\View\Component;

class Footer extends Component
{
    protected $info;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->info = new FrontInfo();
    }

    public function info()
    {
        $info = $this->info->getRelease();
        return $info["data"];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.footer');
    }
}

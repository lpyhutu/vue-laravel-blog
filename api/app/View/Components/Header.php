<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    public function menus()
    {
        return [
            ["title" => "首页", "path" => "/", "icon" => "icon-home"],
            ["title" => "留言板", "path" => "message", "icon" => "icon-comment"],
            ["title" => "友链", "path" => "link", "icon" => "icon-link"],
            ["title" => "关于", "path" => "about", "icon" => "icon-user"],
        ];
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.header');
    }
}

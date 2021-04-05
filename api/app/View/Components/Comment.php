<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Comment extends Component
{
    public $url;
    public $commentId;
    public $emotionDom;
    public $currentEmotionDom;

    /**
     * Create a new component instance.
     * @param string $url
     * @param int $commentId
     * @param $emotionDom
     * @param $currentEmotionDom
     */
    public function __construct($url = "/", $commentId = 0, $emotionDom = "a", $currentEmotionDom = "a")
    {
        $this->url = $url;
        $this->commentId = $commentId;
        $this->emotionDom = $emotionDom;
        $this->currentEmotionDom = $currentEmotionDom;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.comment');
    }
}

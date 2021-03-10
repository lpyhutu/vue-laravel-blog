<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Controllers\Controller;
use App\Http\Requests\IdRequest;
use App\Http\Requests\LogRequest;
use App\Models\FrontLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    protected $log;

    public function __construct()
    {
        $this->log = new FrontLog();
    }

    /**
     * 获取已发布
     * @param Request $request
     * @return array
     */
    public function getRelease(Request $request)
    {
        $start = $request->input("start", 0);
        $pageSize = $request->input("pageSize", 15);
        return $this->log->getRelease($start, $pageSize, 1);
    }
}

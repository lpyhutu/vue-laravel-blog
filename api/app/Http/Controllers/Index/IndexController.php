<?php

namespace App\Http\Controllers\Index;

use App\Http\Common\Code;
use App\Http\Common\RedisKey;
use App\Http\Controllers\Controller;
use App\Models\AdminPower;
use App\Models\FrontTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

class IndexController extends Controller
{

    public function index(Request $request)
    {
        echo date("y-m-d h:i:s",1615294788);
        echo date("y-m-d h:i:s",1615294267957/1000);

//
    }
}

<?php

namespace App\Models;

use App\Http\Common\Code;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class FrontUserVisitsInterval extends Model
{
    protected $table = "blog_front_user_visits_interval";
    protected $dateFormat = 'U';
    protected $fillable = ["ip"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    /**
     * 添加
     * @param string $ip ip
     * @return array
     */
    public function add($ip)
    {
        $visits = FrontUserVisitsInterval::create(["ip" => $ip]);
        if (!$visits) {
            return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "添加失败！"];
        }
        return ["code" => Code::$SUCCESS_NO_TIP, "msg" => "success"];
    }
}

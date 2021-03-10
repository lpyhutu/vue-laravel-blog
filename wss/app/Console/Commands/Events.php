<?php

namespace App\Workerman;

use \GatewayWorker\Lib\Gateway;

class Events
{

    public static function onWorkerStart($businessWorker)
    {
    }

    public static function onConnect($client_id)
    {
    }

    public static function onWebSocketConnect($client_id, $data)
    {
    }

    //接收用户端发信息
    public static function onMessage($client_id, $message)
    {
        $res = json_decode($message);
        switch ($res->type) {
            case "front":
                Gateway::joinGroup($client_id, $res->group);
                Gateway::bindUid($client_id, $client_id);
                break;
            case "admin":
                Gateway::joinGroup($client_id, $res->group);
                break;
        }
        Gateway::sendToGroup("front_login", json_encode([
            "type" => "online",
            "data" =>
            [
                "online" =>  Gateway::getUidCountByGroup("front_login"),
            ]
        ]));
        Gateway::sendToGroup("admin_login", json_encode([
            "type" => "online",
            "data" =>
            [
                "online" =>  Gateway::getUidCountByGroup("front_login"),
            ]
        ]));
    }

    public static function onClose($client_id)
    {
        Gateway::sendToGroup("front_login", json_encode([
            "type" => "online",
            "data" =>
            [
                "online" =>  Gateway::getUidCountByGroup("front_login"),
            ]
        ]));
        Gateway::sendToGroup("admin_login", json_encode([
            "type" => "online",
            "data" =>
            [
                "online" =>  Gateway::getUidCountByGroup("front_login"),
            ]
        ]));
    }
}

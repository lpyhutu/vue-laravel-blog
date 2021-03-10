<?php

namespace App\Console\Commands;

use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use Illuminate\Console\Command;
use Workerman\Worker;

class WorkermanCommand extends Command
{

    protected $signature = 'workman {action} {--d}';

    protected $description = 'Start a Workerman server.';
    // protected $signature = 'workerman
    // {action : action}
    // {--start=all : start}
    // {--d : daemon mode}';

    public function handle()
    {
        global $argv;
        $action = $this->argument('action');

        $argv[0] = 'wk';
        $argv[1] = $action;
        $argv[2] = $this->option('d') ? '-d' : '';

        $this->start();


        // global $argv;
        // $action = $this->argument('action');
        // if ($action === 'single') {
        //     $start = $this->option('start');
        //     if ($start === 'register') {
        //         $this->startRegister();
        //     } elseif ($start === 'gateway') {
        //         $this->startGateWay();
        //     } elseif ($start === 'worker') {
        //         $this->startBusinessWorker();
        //     }
        //     Worker::runAll();

        //     return;
        // }
        // $argv[1] = $action;
        // // 控制是否进入 daemon 模式
        // $argv[2] = $this->option('d') ? '-d' : '';
        // $this->start();
    }

    private function start()
    {
        $this->startGateWay();
        $this->startBusinessWorker();
        $this->startRegister();
        Worker::runAll();
    }

    private function startBusinessWorker()
    {
        $worker                  = new BusinessWorker();
        $worker->name            = 'BusinessWorker';
        $worker->count           = 1;
        $worker->registerAddress = '127.0.0.1:1236';
        $worker->eventHandler    = \App\Workerman\Events::class;
    }

    private function startGateWay()
    {
        $gateway = new Gateway("websocket://0.0.0.0:2346");
        $gateway->name                 = 'Gateway';
        $gateway->count                = 1;
        $gateway->lanIp                = '127.0.0.1';
        $gateway->startPort            = 2300;
        $gateway->pingInterval         = 10;
        $gateway->pingNotResponseLimit = 0;
        $gateway->pingData             = '{"type":"checkLogin"}';
        $gateway->registerAddress      = '127.0.0.1:1236';
    }

    private function startRegister()
    {
        new Register('text://0.0.0.0:1236');
    }
}

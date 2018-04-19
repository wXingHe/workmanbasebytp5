<?php
namespace app\push\controller;

use think\worker\Server;

class Worker extends Server
{
    protected $socket = 'tcp://127.0.0.1:5050';

    protected $data = '';

    /**
     * 收到信息
     * @param $connection
     * @param $data
     */
    public function onMessage($connection, $data)
    {
        if($data == "\r\n"){
            $mes = $this->data;
            $this->data = '';
            $connection->send('we recived:'.$mes."\r\n");
        }else{
            $this->data .=$data;
        }

    }

    /**
     * 当连接建立时触发的回调函数
     * @param $connection
     */
    public function onConnect($connection)
    {
        $connection->send("success LINk!\r\n");
    }

    /**
     * 当连接断开时触发的回调函数
     * @param $connection
     */
    public function onClose($connection)
    {
        $connection->send("break LINK!\r\n");
    }

    /**
     * 当客户端的连接上发生错误时触发
     * @param $connection
     * @param $code
     * @param $msg
     */
    public function onError($connection, $code, $msg)
    {
        echo "error $code $msg\r\n";
    }

    /**
     * 每个进程启动
     * @param $worker
     */
    public function onWorkerStart($worker)
    {
        echo ('start:'.$worker->name."\r\n");
    }
}

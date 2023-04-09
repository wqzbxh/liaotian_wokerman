<?php
/**
 * Created by : phpstorm
 * User: Dumb Lake Monster (Wang Haiyang)
 * Date:  2023/4/9
 * Time:  0:01
 */
//use Workerman\Worker;
namespace app\ExtraExpand\Server;
require_once '../../../vendor/autoload.php';
use Workerman\Worker;


        //创建一个socket协议并且监听99999端口，允许任何人过来
        $socket = new Worker('websocket://0.0.0.0:9999');
        // 启动 10 个进程来处理请求
        $socket->count = 5;
        // 当客户端与服务器建立连接时触发的回调函数
        $socket->onConnect = function($connection) {

            echo "Established link\n";
        };

        // 当客户端发送消息时触发的回调函数
        $socket->onMessage = function($connection, $data) {
            global  $socket;
            // 向客户端发送消息\
//            查看数据
//            $datainfo = json_decode($data,true);
            foreach($socket->connections as $connection)
            {
                $connection->send($data);
            }
        };

        // 当客户端断开连接时触发的回调函数
        $socket->onClose = function($connection) {
            echo "Connection closed\n";
        };
// 运行 worker
        Worker::runAll();


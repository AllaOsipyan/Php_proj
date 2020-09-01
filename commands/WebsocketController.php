<?php


namespace app\commands;

use Amp\Http\Server\HttpServer;
use Amp\Http\Server\StaticContent\DocumentRoot;
use Amp\Log\ConsoleFormatter;
use Amp\Log\StreamHandler;
use Amp\Loop;
use Amp\Promise;
use Amp\Socket\Server;
use Amp\Http\Server\Router;
use Amp\Websocket\Server\Websocket;
use app\commands\wsHandler\WsHandler;
use Monolog\Logger;
use yii\console\Controller;
use yii\console\ExitCode;
use function Amp\ByteStream\getStdout;

class WebsocketController extends Controller
{
    public $websocket;
    public function init()
    {
        parent::init();
        $this->websocket = new Websocket(new WsHandler());
    }

    public function actionRun(){
        Loop::run(function (): Promise {
            $sockets = [

                Server::listen('0.0.0.0:1337')
            ];

            $router = new Router;
            $router->addRoute('GET', '/broadcast', $this->websocket);
            $router->setFallback(new DocumentRoot(__DIR__ . '/../web/public'));

            $logHandler = new StreamHandler(getStdout());
            $logHandler->setFormatter(new ConsoleFormatter);
            $logger = new Logger('server');
            $logger->pushHandler($logHandler);
            $server = new HttpServer($sockets, $router, $logger);

            return $server->start();

        });
        return ExitCode::OK;
    }


}
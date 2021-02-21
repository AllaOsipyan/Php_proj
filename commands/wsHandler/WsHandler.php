<?php

namespace app\commands\wsHandler;

use Amp\Websocket\Server\ClientHandler;
use Amp\Http\Server\HttpServer;
use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use Amp\Http\Server\StaticContent\DocumentRoot;
use Amp\Log\ConsoleFormatter;
use Amp\Log\StreamHandler;
use Amp\Loop;
use Amp\Promise;
use Amp\Socket\Server;
use Amp\Success;
use Amp\Websocket\Client;
use Amp\Websocket\Message;
use Amp\Websocket\Server\Gateway;
use Amp\Websocket\Server\Websocket;
use app\models\Telemetries;
use Monolog\Logger;
use phpDocumentor\Reflection\Types\Array_;
use Yii;
use function Amp\ByteStream\getStdout;
use function Amp\call;
use function assert;
use function sprintf;

class WsHandler implements ClientHandler
{

    private const ALLOWED_ORIGINS = [
        'http://localhost:8500'
    ];
    public function handleHandshake(\Amp\Websocket\Server\Gateway $gateway, \Amp\Http\Server\Request $request, \Amp\Http\Server\Response $response): \Amp\Promise
    {
        /*if (!\in_array($request->getHeader('origin'), self::ALLOWED_ORIGINS, true)) {
            return $gateway->getErrorHandler()->handleError(403);
        }*/
        return new Success($response);
    }

    public function handleClient(Gateway $gateway, Client $client, Request $request, Response $response): \Amp\Promise
    {

        return call(function () use ($gateway, $client): \Generator {
            while ($message = yield $client->receive()) {


                $this->createTelemetry(yield $message->buffer());
                assert($message instanceof Message);
                $gateway->multicast(sprintf(
                    '%s',
                    yield $message->buffer() //сообщение
                ),$array = [
                    $client->getId()
                ]);
            }
        });
    }
    public function createTelemetry( $message)
    {
        $telemetry = new Telemetries();
            $splitData = explode("=", $message);
            $telemetry->name = $splitData[0];
            $telemetry->value = json_encode($splitData[1]);

        $telemetry->time = date("Y-m-d H:i:s");

        if ($telemetry->validate()) {
            $telemetry->save();
        }
    }
}
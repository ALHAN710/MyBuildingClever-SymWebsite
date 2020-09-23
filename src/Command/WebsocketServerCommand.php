<?php

namespace App\Command;

//use DateTime;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\Websocket\MessageHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WebsocketServerCommand extends Command
{
    protected static $defaultName = "run:websocket-server";

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = 1337;
        //$date = new DateTime(date('Y-m-d H:i:s'));
        $output->writeln("Starting server on port " . $port);
        //$output->writeln("Starting server on port " . $port . "at " . $date);
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new MessageHandler()
                )
            ),
            $port
        );
        $server->run();
        return 0;
    }
}

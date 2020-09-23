<?php

namespace App\Websocket;

use Exception;
use SplObjectStorage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use App\Controller\ApplicationController;
use Symfony\Component\HttpClient\HttpClient;




class MessageHandler extends AbstractController implements MessageComponentInterface
{
    protected $connections;

    /** extends ApplicationController
     * + users qui sera la liste des utilisateurs : une liste associative avec la clé qui correspond à l’id de la connexion et dont la valeur est un tableau associatif contenant l’object de connexion, le pseudo de l’utilisateur et la liste des canaux auxquels il est abonné
     * + botName qui sera notre utilisateur par défaut
     * + defaultChannel qui sera le nom du canal par défaut
     * 
     * */
    private $users = [];
    private $botName = 'ChatBot';
    private $defaultChannel = 'general';
    /* The PHP array. */
    private $array = array("From" => "Box", "To" => "user", "Object" => "Connected Clients", "message" => "Hello");

    //private $abstr =  AbstractController::class;

    public function __construct()
    {
        $this->connections = new SplObjectStorage;
        //$this->abstr = new $abstr;
    }

    public function onOpen(ConnectionInterface $conn)
    {

        //$querystring = $conn->httpRequest->getUri()->getQuery();
        //parse_str($querystring, $queryarray);
        //echo $queryarray['token'];
        //echo "\n";
        /*if (!isValid($queryarray['token'])) {
            return;
        }*/
        $this->connections->attach($conn);
        $conn->send(sprintf('Session Id =%d', $conn->resourceId));
        /*$this->users[$conn->resourceId] = [
            'connection' => $conn,
            'user' => '',
            'channels' => []
        ];*/
        //echo sprintf($this->connections);
        /*$this->forward('App\Controller\WebsocketController::Dumping', [
            'conn'       => '1',
        ]);*/
        /*$response = $this->forward('App\Controller\WebsocketController::Dumping', [
            'conn'       => '1',
        ]);*/
        //$client = HttpClient::create();
        //$response = $client->request('GET', 'http://localhost:8000/websocket/test/1');
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo $msg;
        echo "\n";
        $json = json_decode($msg);
        switch ($json->{'To'}) {
            case 'Box':
                if ($json->{'Object'} == "Session Id") {
                    $js = json_decode(json_encode($json->{'message'}));
                    $this->users[$js->{'Id'}] = $js->{'name'};
                    $this->array['Object'] = "Connected Clients";
                    $this->array['message'] = json_encode($this->users);
                    $msg = json_encode($this->array);
                    foreach ($this->connections as $connection) {
                        if ($connection === $from) {
                            continue;
                        }
                        $connection->send($msg);
                    }
                    print_r($this->users);
                    echo "\n";
                } else if ($json->{'Object'} == "Connected clients") {
                    //$json = json_encode($this->users);
                    print_r(json_encode($this->users));
                    echo "\n";
                    $this->array['Object'] = "Connected Clients";
                    $this->array['message'] = json_encode($this->users);
                    $from->send(json_encode($this->array));
                }
                break;

            default:
                foreach ($this->connections as $connection) {
                    if ($connection === $from) {
                        continue;
                    }
                    $connection->send($msg);
                    /*$this->abstr->forward('App\Controller\WebsocketController::Dumping', [
                        'conn'       => $this->connection,

                    ]);*/
                }
                break;
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->connections->detach($conn);
        $this->array['Object'] = "Disconnected Client";
        $this->array['message'] = $this->users["" . $conn->resourceId];
        unset($this->users["" . $conn->resourceId]);
        print_r($this->users);
        echo "\n";
        $msg = json_encode($this->array);
        foreach ($this->connections as $connection) {
            $connection->send($msg);
        }
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        $conn->send('An error has occurred: ' . $e->getMessage());
        print_r('An error has occurred: ' . $e->getMessage());
        echo "\n";
        $this->connections->detach($conn);
        $conn->close();
        //$this->array['Object'] = "Disconnected Client";
        //$this->array['message'] = $this->users["" . $conn->resourceId];
        //unset($this->users["" . $conn->resourceId]);
        //print_r($this->users);
        //echo "\n";
        $msg = json_encode($this->array);
        foreach ($this->connections as $connection) {
            $connection->send($msg);
        }
    }
}

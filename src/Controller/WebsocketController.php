<?php

namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WebsocketController extends AbstractController
{
    /**
     * @Route("/websocket", name="websocket")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY', null, 'User tried to access a page without having ROLE_ADMIN');
        //dump($this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'));
        dump($this);
        return $this->render('websocket/index.html.twig', [
            'controller_name' => 'WebsocketController',
            'ws_url' => 'localhost:1337?token=secret',
        ]);
    }

    /**
     * Undocumented function
     *
     *@Route("/websocket/test/{conn}", name="websocket_test")
     * 
     * @param [type] $conn
     * @return void
     */
    public function Dumping($conn)
    {
        //$data = json_decode($request->getContent(), true);
        //dump($conn);
        return $this->json([
            'code' => 200,
            'received' => $conn

        ], 200);

        /*$client = HttpClient::create();
        $response = $client->request('GET', 'https://api.github.com/repos/symfony/symfony-docs');
        return $response;*/
    }
}

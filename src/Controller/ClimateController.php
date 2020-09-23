<?php

namespace App\Controller;

use App\Repository\DevicesRepository;
use App\Controller\ApplicationController;
use App\Repository\SecuritySystemRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClimateController extends ApplicationController
{
    /**
     * @Route("/climate", name="climate")
     * 
     * @IsGranted("ROLE_USER")
     */
    public function index(SecuritySystemRepository $securityRepo, DevicesRepository $repoDevices)
    {
        return $this->render('climate/index.html.twig', [
            'devicesNb'  => $this->getRepoDevice($repoDevices)['devicesNb'],
            'devicesTab' => $this->getRepoDevice($repoDevices)['devicesTab'],
            'security'   => $securityRepo->findAll(),
            'menu'       => 'Climate',
            //'ws_url' => 'localhost:1337?token=secret',
        ]);
    }
}

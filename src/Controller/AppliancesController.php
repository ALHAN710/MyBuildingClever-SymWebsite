<?php

namespace App\Controller;

use App\Repository\DevicesRepository;
use App\Repository\SecuritySystemRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppliancesController extends ApplicationController
{
    /**
     * @Route("/appliances", name="appliances")
     * 
     * @IsGranted("ROLE_USER")
     */
    public function index(SecuritySystemRepository $securityRepo, DevicesRepository $repoDevices)
    {
        return $this->render('appliances/index_appliances.html.twig', [
            'devicesNb'  => $this->getRepoDevice($repoDevices)['devicesNb'],
            'devicesTab' => $this->getRepoDevice($repoDevices)['devicesTab'],
            'security'   => $securityRepo->findAll(),
            'menu'       => 'Appliances',
            //'ws_url' => 'localhost:1337?token=secret',
        ]);
    }
}

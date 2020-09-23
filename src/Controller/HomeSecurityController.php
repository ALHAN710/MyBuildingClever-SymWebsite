<?php

namespace App\Controller;

use App\Repository\DevicesRepository;
use App\Controller\ApplicationController;
use App\Repository\SecuritySystemRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeSecurityController extends ApplicationController
{
    /**
     * @Route("/home/security", name="home_security")
     * 
     * @IsGranted("ROLE_USER")
     */
    public function index(SecuritySystemRepository $securityRepo, DevicesRepository $repoDevices)
    {
        return $this->render('home_security/security_home.html.twig', [
            //'hasError'   => $error !== null,
            //'username'   => $username,
            'devicesNb'  => $this->getRepoDevice($repoDevices)['devicesNb'],
            'devicesTab' => $this->getRepoDevice($repoDevices)['devicesTab'],
            'security'   => $securityRepo->findAll(),
            'menu'       => 'Home Security',
            //'ws_url' => 'localhost:1337?token=secret',
        ]);
    }
}

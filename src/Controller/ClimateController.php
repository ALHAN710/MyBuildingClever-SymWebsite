<?php

namespace App\Controller;

use App\Entity\Devices;
use App\Repository\DevicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\ApplicationController;
use App\Repository\SecuritySystemRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClimateController extends ApplicationController
{
    /**
     * @Route("/climate/home", name="climate_index")
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

    /**
     * Gestion de la programmation horaire des devices de type CLIMAT
     * 
     * @Route("/climate/{id<\d+>?0}/programming/{tabpanel<\d>?0}", name="climates_programming")
     *
     * @IsGranted("ROLE_USER")
     * 
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param DevicesRepository $repoDevices
     * @return void
     */
    public function climateProgramming($id, $tabpanel, Request $request, EntityManagerInterface $manager, SecuritySystemRepository $securityRepo, DevicesRepository $repoDevices)
    {
        $device = new Devices();

        return $this->render('climate/programming.html.twig', [
            //'form' => $form->createView(),
            'user'       => $this->getUser(),
            'devicesNb'  => $this->getRepoDevice($repoDevices)['devicesNb'],
            'devicesTab' => $this->getRepoDevice($repoDevices)['devicesTab'],
            'security'   => $securityRepo->findAll(),
            'id'         => $id,
            'tabpanel'   => $tabpanel,
            'menu'       => 'Climate',
        ]);
    }

    /**
     * Gestion des requêtes de programmation des devices de type CLIMAT
     * 
     * @Route("/climate/prog", name="climate_prog")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param DevicesRepository $devicesRepo
     * @return void
     */
    public function climateProg(Request $request, EntityManagerInterface $manager, DevicesRepository $devicesRepo)
    {
        //Récupération et vérification des paramètres au format JSON contenu dans la requête
        $paramJSON = $this->getJSONRequest($request->getContent());
        //dump($paramJSON);
        $action   = $paramJSON['action'];
        if ($action == 'save') {
            $arr = json_decode($paramJSON['prog'], true);
            //$arr = $this->getJSONRequest($paramJSON['prog']);
            //dump($arr);
            //Recherche du device dans la BDD
            $device = $devicesRepo->findOneBy(['name' => $arr['outName']]);

            //dump($device);
            if ($device != null) { // Test si le device existe dans notre BDD
                $device->setProgramming($arr);
                $manager->persist($device);
                $manager->flush();

                return $this->json([
                    'code'     => 200,
                    'received' => $paramJSON,
                    'success'  => 1,

                ], 200);
            }
        } else if ($action == 'get prog') {

            //$arr = $this->getJSONRequest($paramJSON['prog']);
            //Recherche du device dans la BDD
            $criteria = $paramJSON['criteria'];
            if ($criteria == 'name') {
                $name = $paramJSON['name'];
                $device = $devicesRepo->findOneBy(['name' => $name]);
            } else if ($criteria == 'moduleId') {
                $id = $paramJSON['moduleId'];
                $device = $devicesRepo->findOneBy(['moduleId' => $id]);
            }

            //dump($device);
            if ($device != null) { // Test si le device existe dans notre BDD
                $jsonProg = $device->getProgramming();
                //dump($jsonProg);
                return $this->json([
                    'code'     => 200,
                    'prog'     => $jsonProg,
                    'success'  => ($jsonProg == null ? 0 : 1),

                ], 200);
            }
        }
    }
}

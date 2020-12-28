<?php

namespace App\Controller;

use App\Entity\Devices;
use App\Repository\DevicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SecuritySystemRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LightsController extends ApplicationController
{
    /**
     * @Route("/lights", name="lights")
     * 
     * @IsGranted("ROLE_USER")
     */
    public function index(SecuritySystemRepository $securityRepo, DevicesRepository $repoDevices)
    {
        /*$array1 = array("Orange" => 100, "Apple" => 200, "Banana" => 300, "Cherry" => 400);
        if (array_key_exists("Banana", $array1)) {
            dump("Array Key exists...");
            dump($array1['Banana']);
        } else {
            dump("Array Key does not exist...");
        }*/
        return $this->render('lights/index_lights.html.twig', [
            'devicesNb'  => $this->getRepoDevice($repoDevices)['devicesNb'],
            'devicesTab' => $this->getRepoDevice($repoDevices)['devicesTab'],
            'security'   => $securityRepo->findAll(),
            'menu'       => 'Lights',
        ]);
    }

    /**
     * Gestion de la programmation horaire des devices de type LIGHT
     * 
     * @Route("/lights/{id<\d+>?0}/programming/{tabpanel<\d>?0}", name="lights_programming")
     *
     * @IsGranted("ROLE_USER")
     * 
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param DevicesRepository $repoDevices
     * @return void
     */
    public function lightsProgramming($id, $tabpanel, Request $request, EntityManagerInterface $manager, SecuritySystemRepository $securityRepo, DevicesRepository $repoDevices)
    {
        $device = new Devices();

        //Permet d'obtenir un constructeur de formulaire
        // Externaliser la création du formulaire avec la cmd php bin/console make:form

        //  instancier un form externe
        //$form = $this->createForm(DevicesType::class, $device);
        //$form->handleRequest($request);

        return $this->render('lights/programming.html.twig', [
            //'form' => $form->createView(),
            'user'       => $this->getUser(),
            'devicesNb'  => $this->getRepoDevice($repoDevices)['devicesNb'],
            'devicesTab' => $this->getRepoDevice($repoDevices)['devicesTab'],
            'security'   => $securityRepo->findAll(),
            'id'         => $id,
            'tabpanel'   => $tabpanel,
            'menu'       => 'Lights',
        ]);
    }

    /**
     * Gestion des requêtes de programmation des devices de type LIGHT
     * 
     * @Route("/lights/prog", name="light_prog")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param DevicesRepository $devicesRepo
     * @return void
     */
    public function lightProg(Request $request, EntityManagerInterface $manager, DevicesRepository $devicesRepo)
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
            $device = $devicesRepo->findOneBy([
                'name' => $arr['outName'],
                'type' => $paramJSON['type']
            ]);

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
                $device = $devicesRepo->findOneBy([
                    'name' => $name,
                    'type' => $paramJSON['type']
                ]);
            } else if ($criteria == 'moduleId') {
                $id = $paramJSON['moduleId'];
                $device = $devicesRepo->findOneBy([
                    'moduleId' => $id,
                    'type' => $paramJSON['type']
                ]);
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

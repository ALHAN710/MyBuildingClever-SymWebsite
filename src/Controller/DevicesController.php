<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use App\Entity\User;
use App\Entity\Devices;
use App\Form\DevicesType;
use Cocur\Slugify\Slugify;
use App\Repository\DevicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Contrôleur des Devices
 * 
 */
class DevicesController extends ApplicationController
{
    /**
     * @Route("/devices", name="devices")
     */
    public function index()
    {
        return $this->render('devices/index.html.twig', [
            'controller_name' => 'DevicesController',
        ]);
    }

    /**
     * Permet de créer un nouvel équipement
     *
     * @Route("/admin/devices/new", name = "super_admin_devices_create")
     * @IsGranted("ROLE_SUPER_ADMIN")
     * 
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager, DevicesRepository $repoDevices)
    {
        $device = new Devices();

        //Permet d'obtenir un constructeur de formulaire
        // Externaliser la création du formulaire avec la cmd php bin/console make:form

        //  instancier un form externe
        $form = $this->createForm(DevicesType::class, $device);
        $form->handleRequest($request);
        //dump($site);

        if ($form->isSubmitted() && $form->isValid()) {

            //$manager = $this->getDoctrine()->getManager();
            $manager->persist($device);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'équipement <strong>{$device->getName()}</strong> a bien été créé !"
            );

            return $this->redirectToRoute('super_admin_settings', [
                'page'     => 1,
                'tabpanel' => 1,
                'menu'       => 'Settings',
            ]);
        }


        return $this->render('devices/new.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(),
            'devicesNb'  => $this->getRepoDevice($repoDevices)['devicesNb'],
            'devicesTab' => $this->getRepoDevice($repoDevices)['devicesTab'],
            'menu'       => 'Settings',
        ]);
    }

    /**
     * Permet d'afficher le formulaire d'édition d'un équipement
     *
     * @Route("/admin/devices/{id<\d+>}/edit", name="super_admin_devices_edit")
     * @IsGranted("ROLE_SUPER_ADMIN")
     *
     * 
     * @return Response
     */
    public function edit(Devices $device, Request $request, EntityManagerInterface $manager, DevicesRepository $repoDevices)
    {
        //dump($device);
        //  instancier un form externe
        $form = $this->createForm(DevicesType::class, $device);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugify = new Slugify();
            $device->setSlug($slugify->slugify($device->getName()));
            //$manager = $this->getDoctrine()->getManager();
            $manager->persist($device);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modifications de l'équipement <strong>{$device->getName()}</strong> ont  bien été enregistrées !"
            );

            return $this->redirectToRoute('super_admin_settings', [
                'page'     => 1,
                'tabpanel' => 1,
                'menu'       => 'Settings',
            ]);
        }

        return $this->render('devices/edit.html.twig', [
            'form' => $form->createView(),
            'device' => $device,
            'devicesNb'  => $this->getRepoDevice($repoDevices)['devicesNb'],
            'devicesTab' => $this->getRepoDevice($repoDevices)['devicesTab'],
            'menu'       => 'Settings',
        ]);
    }

    /**
     * Permet de supprimer un équipement
     * 
     * @Route("/admin/devices/{id<\d+>}/delete", name="super_admin_devices_delete")
     * @IsGranted("ROLE_SUPER_ADMIN")
     *
     * @param Devices $device
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(Devices $device, EntityManagerInterface $manager)
    {
        $name = $device->getName();
        $manager->remove($device);
        $manager->flush();

        $this->addFlash(
            'success',
            "La suppression de l'équipement <strong>{$name}</strong> a été effectuées avec succès !"
        );

        return $this->redirectToRoute('super_admin_settings', [
            'page'     => 1,
            'tabpanel' => 1,
            'menu'       => 'Settings',
        ]);
    }

    /**
     * Gère les requêtes de modification des adresses IP des devices
     * 
     * @Route("/devices/ipAddress", name="devices_set_ipAddress")
     *
     * @return Request
     */
    public function devicesIP(Request $request, EntityManagerInterface $manager, DevicesRepository $devicesRepo)
    {
        //Récupération et vérification des paramètres au format JSON contenu dans la requête
        $paramJSON = $this->getJSONRequest($request->getContent());

        $modId   = $paramJSON['moduleId'];
        $ipAddress = $paramJSON['IPaddress'];

        //$devicesRepo = $manager->getRepository(DevicesRepository::class);

        //Recherche du device dans la BDD
        $device = $devicesRepo->findOneBy(['moduleId' => $modId]);

        dump($device);
        if ($device != null) { // Test si le device existe dans notre BDD

            $device->setIpaddress($ipAddress);

            $manager->persist($device);
            $manager->flush();


            return $this->json([
                'code' => 200,
                'received' => $paramJSON

            ], 200);
            /*return $this->render("security_alarm/security_alarm.html.twig", [
                'device' => $device
            ]);*/
        }
        return $this->json([
            'code' => 403,
            'message' => "Device don't exist",
            'received' => $paramJSON

        ], 403);
    }

    /**
     * Permet d'afficher les graphes d'un module
     *
     * @Route("/smart/mods/dashboard", name="show_mods_graphs")
     * 
     * @IsGranted("ROLE_ADMIN")
     * 
     * @return Response
     */
    public function showDashboard(DevicesRepository $repoDevices)
    {
        /*return $this->render('smart_mod/showGraph.html.twig', [
            'smartMod' => $smartMod,
            'user' => $smartMod->getSite()->getUser()
        ]);*/
        //$smartMods = $smartModRepo->findBy(['type' => 'Smart Meter']);
        return $this->render('devices/dashboardMeter.html.twig', [
            //'smartMod' => $smartMods,
            'devicesNb'  => $this->getRepoDevice($repoDevices)['devicesNb'],
            'devicesTab' => $this->getRepoDevice($repoDevices)['devicesTab'],
            'menu'     => 'Dashboard',
        ]);
    }

    /**
     * Permet de mettre à jour les graphes liés aux données d'un module
     *
     * @Route("/update/smart/mods/dashboard/",name="update_mods_graphs")
     * 
     * @param [interger] $id
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function updateDashboard(DevicesRepository $smartModRepo, EntityManagerInterface $manager, Request $request): Response
    {

        $EA       = [];
        $Pmax     = [];
        $Pmoy     = [];

        //Tableau de données du mois passé
        $precEA       = [];
        $precPmax     = [];
        $precPmoy     = [];

        $paramJSON = $this->getJSONRequest($request->getContent());
        //dump($paramJSON['selectedDate']);
        //dump($request->getContent());
        //die();
        $maxDate        = 0;
        $dat            = $paramJSON['selectedDate'];
        $dataenergySmartMeter       = [];
        //$dataFuel       = [];
        $precDataEnergySmartMeter   = [];
        //$precDataFuel   = [];
        $tabEA_energySmartMeter     = [];
        $prectabEA_energySmartMeter = [];
        // $tabEA_fuel     = [];
        // $prectabEA_fuel = [];
        // $subscription   = '';
        // $Psous          = 0;
        /*if (!empty($paramJSON['selectedgridId'])) {
            $smartMod = $smartModRepo->findOneBy(['id' => $paramJSON['selectedgridId']]);
            // $subscription = $smartMod->getSite()->getSubscription();
            // $Psous = $smartMod->getSite()->getPsous();
        } else {
            $smartMod = $smartModRepo->findOneBy(['id' => $paramJSON['selectedfuelId']]);
            // $subscription = $smartMod->getSite()->getSubscription();
            // $Psous = $smartMod->getSite()->getPsous();
        }*/
        if (!empty($paramJSON['energySmartMeterIds'])) {
            foreach ($paramJSON['energySmartMeterIds'] as $energySmartMeterId) {

                $dataenergySmartMeter['' . $energySmartMeterId . ''] = $manager->createQuery("SELECT SUM(d.ea) AS EA, SUM(d.er) AS ER, MAX(d.datetime) AS DateTimeMax,
                                            MAX(d.pmax) AS Pmax, AVG(d.pmoy) AS Pmoy, SUM(d.ea) / SQRT( (SUM(d.ea)*SUM(d.ea)) + (SUM(d.er)*SUM(d.er)) ) AS Cosphi
                                            FROM App\Entity\DataMod d
                                            JOIN d.smartmod sm 
                                            WHERE d.datetime LIKE :selDate
                                            AND sm.id = :modId
                                                                                                                                
                                            ")
                    ->setParameters(array(
                        'selDate' => $dat,
                        'modId'   => $energySmartMeterId
                    ))
                    ->getResult();
                $EA['' . $energySmartMeterId . '']     = number_format((float) $dataenergySmartMeter['' . $energySmartMeterId . ''][0]['EA'], 2, '.', ' ');
                //$ER['' . $energySmartMeterId . '']     = number_format((float) $dataenergySmartMeter['' . $energySmartMeterId . ''][0]['ER'], 2, '.', ' ');
                $Pmax['' . $energySmartMeterId . '']   = number_format((float) $dataenergySmartMeter['' . $energySmartMeterId . ''][0]['Pmax'], 2, '.', ' ');
                $Pmoy['' . $energySmartMeterId . '']   = number_format((float) $dataenergySmartMeter['' . $energySmartMeterId . ''][0]['Pmoy'], 2, '.', ' ');
                //$Cosphi['' . $energySmartMeterId . ''] = number_format((float) $dataenergySmartMeter['' . $energySmartMeterId . ''][0]['Cosphi'], 2, '.', ' ');

                $maxDate = $dataenergySmartMeter['' . $energySmartMeterId . ''][0]['DateTimeMax'];
                //dump($maxDate);
                if ($maxDate == null) {
                    $dateStr = str_replace("%", "", $dat);
                    $maxDate = $dateStr;
                }

                $date = new DateTime($maxDate);
                //dump($date);
                $interval = new DateInterval('P1M'); //P10D P1M
                $date->sub($interval);
                //dump($date);

                //Récupération des données du mois passé
                $precDataEnergySmartMeter['' . $energySmartMeterId . ''] = $manager->createQuery("SELECT SUM(d.ea) AS EA, SUM(d.er) AS ER,
                                            MAX(d.pmax) AS Pmax, AVG(d.pmoy) AS Pmoy, SUM(d.ea) / SQRT( (SUM(d.ea)*SUM(d.ea)) + (SUM(d.er)*SUM(d.er)) ) AS Cosphi
                                            FROM App\Entity\DataMod d
                                            JOIN d.smartmod sm 
                                            WHERE d.datetime <= :selDate
                                            AND sm.id = :modId
                                                                                                                                
                                            ")
                    ->setParameters(array(
                        'selDate' => $date->format('Y-m-d H:i:s'),
                        'modId'   => $energySmartMeterId
                    ))
                    ->getResult();
                //dump($precDataenergySmartMeter['' . $energySmartMeterId . '']);
                $precEA['' . $energySmartMeterId . '']     = number_format((float) $precDataEnergySmartMeter['' . $energySmartMeterId . ''][0]['EA'], 2, '.', ' ');
                $precER['' . $energySmartMeterId . '']     = number_format((float) $precDataEnergySmartMeter['' . $energySmartMeterId . ''][0]['ER'], 2, '.', ' ');
                $precPmax['' . $energySmartMeterId . '']   = number_format((float) $precDataEnergySmartMeter['' . $energySmartMeterId . ''][0]['Pmax'], 2, '.', ' ');
                $precPmoy['' . $energySmartMeterId . '']   = number_format((float) $precDataEnergySmartMeter['' . $energySmartMeterId . ''][0]['Pmoy'], 2, '.', ' ');
                $precCosphi['' . $energySmartMeterId . ''] = number_format((float) $precDataEnergySmartMeter['' . $energySmartMeterId . ''][0]['Cosphi'], 2, '.', ' ');

                //Calcul des dépenses énergétiques
                if ($paramJSON['selectedEnergySmartMeterId'] == $energySmartMeterId) {
                    $tabEA_energySmartMeter['' . $energySmartMeterId . ''] = $manager->createQuery("SELECT d.ea AS EA, d.datetime AS DAT
                                            FROM App\Entity\DataMod d
                                            JOIN d.smartmod sm 
                                            WHERE d.datetime LIKE :selDate
                                            AND sm.id = :modId                                                                              
                                            ")
                        ->setParameters(array(
                            'selDate' => $dat,
                            'modId'   => $energySmartMeterId
                        ))
                        ->getResult();
                    //dump($tabEA_energySmartMeter['' . $energySmartMeterId . '']);

                    //Récupération des données du mois passé
                    $prectabEA_energySmartMeter['' . $energySmartMeterId . ''] = $manager->createQuery("SELECT d.ea AS EA, d.datetime AS DAT
                                            FROM App\Entity\DataMod d
                                            JOIN d.smartmod sm 
                                            WHERE d.datetime LIKE :selDate
                                            AND sm.id = :modId                                                                              
                                            ")
                        ->setParameters(array(
                            'selDate' => $date->format('Y-m-d H:i:s'),
                            'modId'   => $energySmartMeterId
                        ))
                        ->getResult();
                }
            }
        }

        /*if (!empty($paramJSON['fuelIds'])) {
            foreach ($paramJSON['fuelIds'] as $fuelId) {

                $dataFuel['' . $fuelId . ''] = $manager->createQuery("SELECT SUM(d.kWh) AS EA, SUM(d.kVarh) AS ER, MAX(d.dateTime) AS DateTimeMax,
                                            Sum(d.liters) AS Liters, SUM(d.workingtime) AS WorkingTime, SUM(d.kWh) / SQRT( (SUM(d.kWh)*SUM(d.kWh)) + (SUM(d.kVarh)*SUM(d.kVarh)) ) AS Cosphi
                                            FROM App\Entity\DataMod d
                                            JOIN d.smartMod sm 
                                            WHERE d.dateTime LIKE :selDate
                                            AND sm.id = :modId
                                                                                                                                
                                            ")
                ->setParameters(array(
                    'selDate' => $dat,
                    'modId'   => $fuelId
                ))
                    ->getResult();
                $EA['' . $fuelId . '']       = number_format((float) $dataFuel['' . $fuelId . ''][0]['EA'], 2, '.', ' ');
                $ER['' . $fuelId . '']       = number_format((float) $dataFuel['' . $fuelId . ''][0]['ER'], 2, '.', ' ');
                $Liters['' . $fuelId . '']   = number_format((float) $dataFuel['' . $fuelId . ''][0]['Liters'], 2, '.', ' ');
                $WorkTime['' . $fuelId . ''] = date("H:i:s", $dataFuel['' . $fuelId . ''][0]['WorkingTime'] / 1000);
                $Cosphi['' . $fuelId . '']   = number_format((float) $dataFuel['' . $fuelId . ''][0]['Cosphi'], 2, '.', ' ');

                $maxDate = $dataFuel['' . $fuelId . ''][0]['DateTimeMax'];
                if ($maxDate == null) {
                    $dateStr = str_replace("%", "", $dat);
                    $maxDate = $dateStr;
                }
                $date = new DateTime($maxDate);
                $interval = new DateInterval('P1M'); //P10D P1M
                $date->sub($interval);

                $precDataFuel['' . $fuelId . ''] = $manager->createQuery("SELECT SUM(d.kWh) AS EA, SUM(d.kVarh) AS ER, MAX(d.dateTime) AS DateTimeMax,
                                            Sum(d.liters) AS Liters, SUM(d.workingtime) AS WorkingTime, SUM(d.kWh) / SQRT( (SUM(d.kWh)*SUM(d.kWh)) + (SUM(d.kVarh)*SUM(d.kVarh)) ) AS Cosphi
                                            FROM App\Entity\DataMod d
                                            JOIN d.smartMod sm 
                                            WHERE d.dateTime <= :selDate
                                            AND sm.id = :modId
                                                                                                                                
                                            ")
                ->setParameters(array(
                    'selDate' => $date->format('Y-m-d H:i:s'),
                    'modId'   => $fuelId
                ))
                    ->getResult();
                $precEA['' . $fuelId . '']       = number_format((float) $precDataFuel['' . $fuelId . ''][0]['EA'], 2, '.', ' ');
                $precER['' . $fuelId . '']       = number_format((float) $precDataFuel['' . $fuelId . ''][0]['ER'], 2, '.', ' ');
                $precLiters['' . $fuelId . '']   = number_format((float) $precDataFuel['' . $fuelId . ''][0]['Liters'], 2, '.', ' ');
                $precWorkTime['' . $fuelId . ''] = date("H:i:s", $precDataFuel['' . $fuelId . ''][0]['WorkingTime'] / 1000);
                $precCosphi['' . $fuelId . '']   = number_format((float) $precDataFuel['' . $fuelId . ''][0]['Cosphi'], 2, '.', ' ');
                $maxDate = $precDataFuel['' . $fuelId . ''][0]['DateTimeMax'];

                //Calcul des dépenses énergétiques
                if ($paramJSON['selectedfuelId'] == $fuelId) {
                    //$smartMod = $smartModRepo->findOneBy(['id' => $fuelId]);
                    //$const = 1.192;
                    $workTime = date("H:i:s", $dataFuel['' . $fuelId . ''][0]['WorkingTime'] / 1000);
                    $precworkTime = date("H:i:s", $precDataFuel['' . $fuelId . ''][0]['WorkingTime'] / 1000);
                    //$subscription = $smartMod->getSite()->getSubscription(); 
                    //if ($subscription == 'MT') {
                    //$Psous = $smartMod->getSite()->getPsous();
                    $tabEA_fuel['' . $fuelId . ''] = $manager->createQuery("SELECT d.kWh AS EA, d.dateTime AS DAT
                                            FROM App\Entity\DataMod d
                                            JOIN d.smartMod sm 
                                            WHERE d.dateTime LIKE :selDate
                                            AND sm.id = :modId                                                                              
                                            ")
                    ->setParameters(array(
                        'selDate' => $dat,
                        'modId'   => $fuelId
                    ))
                        ->getResult();
                    //dump($tabEA_fuel['' . $fuelId . '']);

                    //Récupération des données du mois passé
                    $prectabEA_fuel['' . $fuelId . ''] = $manager->createQuery("SELECT d.kWh AS EA, d.dateTime AS DAT
                                            FROM App\Entity\DataMod d
                                            JOIN d.smartMod sm 
                                            WHERE d.dateTime LIKE :selDate
                                            AND sm.id = :modId                                                                              
                                            ")
                    ->setParameters(array(
                        'selDate' => $date->format('Y-m-d H:i:s'),
                        'modId'   => $fuelId
                    ))
                        ->getResult();
                    //}
                }
            }

         
        }*/

        //dump($precDataGrid['' . $gridId . '']);
        return $this->json([
            'EA'                          => $EA,
            //'ER'              => $ER,
            //'Cos'             => $Cosphi,
            'Pmax'                        => $Pmax,
            'Pmoy'                        => $Pmoy,
            'precEA'                      => $precEA,
            'precER'                      => $precER,
            'precCos'                     => $precCosphi,
            'precPmax'                    => $precPmax,
            'precPmoy'                    => $precPmoy,
            'tabEA_energySmartMeter'      => $tabEA_energySmartMeter['' . $paramJSON['selectedEnergySmartMeterId'] . ''],
            'prectabEA_energySmartMeter'  => $prectabEA_energySmartMeter['' . $paramJSON['selectedEnergySmartMeterId'] . ''],
            //'tabEA_fuel'      => $tabEA_fuel['' . $paramJSON['selectedfuelId'] . ''],
            //'prectabEA_fuel'  => $prectabEA_fuel['' . $paramJSON['selectedfuelId'] . ''],
            //'subscription'    => $subscription,
            //'Psous'           => $Psous,

        ], 200);

        //$smartModRepo = $this->getDoctrine()->getRepository(SmartModRepository::class);
        //$smartMod = $smartModRepo->find($id);
        //dump($smartModRepo);
        //dump($smartMod->getModType());
        //$temps = DateTime::createFromFormat("d-m-Y H:i:s", "120");
        //dump($temps);
        //die();
        /*$date        = [];
        $V           = [];
        $S           = [];
        $kWh         = [];
        $kVarh       = [];
        $dateE       = [];

        $dateparam = $request->get('selectedDate'); // Ex : %2020-03-20%
        //$dat = "2020-02"; //'%' . $dat . '%'
        $dat = substr($dateparam, 0, 8); // Ex : %2020-03
        //dump($dat);
        //die();
        $dat = $dat . '%';

        $smartMods = $smartModRepo->findBy(['type' => 'Smart Meter']);
        foreach ($smartMods as $smartMod) {
            # code...
        }
        if ($smartMod->getType() == 'GRID') {
            $data = $manager->createQuery("SELECT d.datetime as dat, d.vmoy, d.vmin, d.vmax, d.smoy, d.smax
                                        FROM App\Entity\DataMod d 
                                        JOIN d.smartmod sm
                                        WHERE d.datetime LIKE :selDate
                                        AND sm.id = :smartModId
                                        ORDER BY dat ASC
                                        
                                        ")
                ->setParameters(array(
                    'selDate'      => $dateparam,
                    'smartModId'   => $id
                ))
                ->getResult();

            foreach ($data as $d) {
                $date[]    = $d['dat']->format('Y-m-d H:i:s');
                $V[]      = $d['va'];
                $S[]      = $d['sa'];
                //$kWh[]   = $d['kWh'];
                //$kVarh[] = $d['kVarh'];
            }

            //dump($Energy);
            //die();

            return $this->json([
                'code'    => 200,
                'selDate' => $dateparam,
                'date'    => $date,
                'V'       => $V,
                'S'       => $S,
                'dateE'   => $dateE,
                'kWh'     => $kWh,
                'kVarh'   => $kVarh,
            ], 200);
        }

        return $this->json([
            'code'         => 200,
            'selDate'      => $dateparam,
            'date'         => $date,
            'V'            => $V,
            'S'            => $S,
            'dateE'        => $dateE,
            'kWh'          => $kWh,
            'kVarh'        => $kVarh,

        ], 200);*/
    }

    /**
     * Gère les requêtes de connectivité des devices
     * 
     * @Route("/devices/connection", name="devices_connection")
     *
     * @return Request
     */
    public function devicesConnection(Request $request, EntityManagerInterface $manager)
    {
        //Récupération et vérification des paramètres au format JSON contenu dans la requête
        $paramJSON = $this->getJSONRequest($request->getContent());

        $modId   = $paramJSON['moduleId'];
        $connect = $paramJSON['connect'] ? true : false;

        $devicesRepo = $manager->getRepository(DevicesRepository::class);

        //Recherche du device dans la BDD
        $device = $devicesRepo->findOneBy(['moduleId' => $modId]);

        dump($device);
        if ($device != null) { // Test si le device existe dans notre BDD

            if ($device->getConnectionState() == false) {
                $device->setConnectionState(true);

                $manager->persist($device);
                $manager->flush();

                //Mise à jour des interfaces des clients connectés par "websocket"


                /*return $this->json([
                    'code' => 200,
                    'received' => $paramJSON
    
                ], 200);*/
                return $this->render("security_alarm/security_alarm.html.twig", [
                    'device' => $device
                ]);
            }
        }
        /*return $this->json([
            'code' => 403,
            'message' => "Device don't exist",
            'received' => $paramJSON

        ], 403);*/
    }
}

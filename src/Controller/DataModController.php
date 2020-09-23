<?php

namespace App\Controller;

use DateTime;
use App\Entity\DataMod;
use App\Repository\DevicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\ApplicationController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DataModController extends ApplicationController
{
    /**
     * @Route("/data/mod", name="data_mod")
     */
    public function index()
    {
        return $this->render('data_mod/index.html.twig', [
            'controller_name' => 'DataModController',
        ]);
    }

    /**
     * Permet de surcharger les données des modules dans la BDD
     *
     * @Route("/data/mod/{modId<[a-zA-Z0-9]+>}/add", name="dataMod_add") 
     * 
     * @param SmartMod $smartMod
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return void
     */
    public function dataMod_add($modId, DevicesRepository $smartModRepo, EntityManagerInterface $manager, Request $request)
    {
        //Récupération et vérification des paramètres au format JSON contenu dans la requête
        $paramJSON = $this->getJSONRequest($request->getContent());
        //dump($paramJSON);
        //dump($content);
        //die();

        $dataMod = new DataMod();

        //Recherche du module dans la BDD
        $smartMod = $smartModRepo->findOneBy(['moduleId' => $modId]);


        if ($smartMod != null) { // Test si le module existe dans notre BDD
            //data:{"date": "2020-03-20 12:15:00", "sa": 1.2, "sb": 0.7, "sc": 0.85, "va": 225, "vb": 230, "vc": 231, "s3ph": 2.75, "kWh": 1.02, "kvar": 0.4}
            //dump($smartMod);//Affiche le module
            //die();

            //$date = new DateTime($paramJSON['date']);


            //Paramétrage des champs de la nouvelle dataMod aux valeurs contenues dans la requête du module
            if (array_key_exists("date", $paramJSON)) {
                //Récupération de la date dans la requête et transformation en object de type Date au format date SQL
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $paramJSON['date']);
                //dump($date);
                //die();
                $dataMod->setDateTime($date);
                if (array_key_exists("V", $paramJSON)) {
                    $dataMod->setVmin($paramJSON['V'][0])
                        ->setVmax($paramJSON['V'][1])
                        ->setVmoy($paramJSON['V'][0]);
                }
                if (array_key_exists("P", $paramJSON)) {
                    $dataMod->setPmax($paramJSON['P'][0])
                        ->setPmoy($paramJSON['P'][1]);
                }
                if (array_key_exists("Q", $paramJSON)) {
                    $dataMod->setQmax($paramJSON['Q'][0])
                        ->setQmoy($paramJSON['Q'][1]);
                }
                if (array_key_exists("S", $paramJSON)) {
                    $dataMod->setSmax($paramJSON['S'][0])
                        ->setSmoy($paramJSON['S'][1]);
                }
                if (array_key_exists("Cos", $paramJSON)) {
                    $dataMod->setCosmin($paramJSON['Cos'][0])
                        ->setCosmn($paramJSON['Cos'][1]);
                }
                if (array_key_exists("E", $paramJSON)) {
                    $dataMod->setEa($paramJSON['E'][0])
                        ->setEr($paramJSON['E'][1])
                        ->setEaindex($paramJSON['E'][2]);
                }
                $dataMod->setSmartMod($smartMod);
                //dump($dataMod);
                //die();
                //Insertion de la nouvelle dataMod dans la BDD
                $manager->persist($dataMod);
                $manager->flush();

                return $this->json([
                    'code' => 200,
                    'received' => $paramJSON

                ], 200);
            } else {
                return $this->json([
                    'code' => 403,
                    'message' => "Bad JSON format",
                    'received' => $paramJSON

                ], 403);
            }

            /* if ($smartMod->getModType() == 'FUEL') {
                $dataMod->setS3phmax($paramJSON['smax'])
                ->setLiters($paramJSON['liters'])
                ->setWorkingtime($paramJSON['workingtime']);

                //++++++++++ Calcul du stock actuel ++++++++++

                //Récupération de la date directement inférieure à la nouvelle date(prevDate)
                $prevDate = $manager->createQuery("SELECT MAX(d.dateTime) AS prevDate
                                      FROM App\Entity\DataMod d
                                      JOIN d.smartMod sm
                                      WHERE d.dateTime < :Dat 
                                      AND sm.id = :modId
                                    ")
                ->setParameters(array(
                    'Dat' => $date,
                    'modId' => $smartMod->getId()
                ))
                    ->getResult();
                //dump($prevDate);
                //die();

                //Récupération du stock à la date prevDate
                $prevStock = $manager->createQuery("SELECT d.stock 
                                        FROM App\Entity\DataMod d
                                        JOIN d.smartMod sm 
                                        WHERE d.dateTime = :prevDate
                                        AND sm.id = :modId
                                                                              
                                        ")
                ->setParameters(array(
                    'prevDate' => $prevDate[0]['prevDate'],
                    'modId'   => $smartMod->getId()
                ))
                    ->getResult();
                //dump($prevStock);

                //Récupération des appro compris prevDate et actualDate
                $sumAppro = $manager->createQuery("SELECT SUM(d.quantity) AS sumAppro
                                        FROM App\Entity\ApproFuel d
                                        JOIN d.smartMod sm 
                                        WHERE d.addAt <= :Dat AND d.addAt >= :initDate
                                        AND sm.id = :modId
                                                                              
                                        ")
                ->setParameters(array(
                    'Dat'     => $date,
                    'initDate' => $prevDate[0]['prevDate'],
                    'modId'    => $smartMod->getId()
                ))
                    ->getResult();
                //dump($sumAppro);
                //die();

                //Récupération de la conso
                $conso = $paramJSON['liters'];
                //dump($conso);

                //Calcul du stock actuel
                $stock = $prevStock[0]['stock'] + $sumAppro[0]['sumAppro'] - $conso;
                //dump($stock);
                //die();

                $dataMod->setStock($stock);
            }*/
        }
        return $this->json([
            'code' => 403,
            'message' => "SmartMeter don't exist",
            'received' => $paramJSON

        ], 403);
    }
}

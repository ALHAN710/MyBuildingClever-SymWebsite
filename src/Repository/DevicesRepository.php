<?php

namespace App\Repository;

use App\Entity\Devices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Devices|null find($id, $lockMode = null, $lockVersion = null)
 * @method Devices|null findOneBy(array $criteria, array $orderBy = null)
 * @method Devices[]    findAll()
 * @method Devices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Devices::class);
    }

    // /**
    //  * @return Devices[] Returns an array of Devices objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Devices
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Numbers of Camera
     *
     * @return integer|null
     */
    public function getNumberOfCamera(): ?int
    {
        return count($this->findBy(['type' => 'Camera']));
    }

    public function getCameraDevice()
    {
        return $this->findBy(['type' => 'Camera']);
    }

    /**
     * Number of Motion Sensor 
     *
     * @return integer|null
     */
    public function getNumberOfMotionSensor(): ?int
    {
        return count($this->findBy(['type' => 'Sensor', 'alerte' => 'Intrusion']));
    }

    public function getMotionSensorDevice()
    {
        return $this->findBy(['type' => 'Sensor', 'alerte' => 'Intrusion']);
    }

    /**
     * Number of Fire Sensor 
     *
     * @return integer|null
     */
    public function getNumberOfFireSensor(): ?int
    {
        return count($this->findBy(['type' => 'Sensor', 'alerte' => 'Fire']));
    }

    public function getFireSensorDevice()
    {
        return $this->findBy(['type' => 'Sensor', 'alerte' => 'Fire']);
    }

    /**
     * Number of Flood Sensor
     *
     * @return integer|null
     */
    public function getNumberOfFloodSensor(): ?int
    {
        return count($this->findBy(['type' => 'Sensor', 'alerte' => 'Flood']));
    }

    public function getFloodSensorDevice()
    {
        return $this->findBy(['type' => 'Sensor', 'alerte' => 'Flood']);
    }

    /**
     * Number of Door Sensor
     *
     * @return integer|null
     */
    public function getNumberOfDoorSensor(): ?int
    {
        return count($this->findBy(['type' => 'Sensor', 'alerte' => 'Opening']));
    }

    public function getDoorSensorDevice()
    {
        return $this->findBy(['type' => 'Sensor', 'alerte' => 'Opening']);
    }

    /**
     * Number of Alarm Devices 
     *
     * @return integer|null
     */
    public function getNumberOfAlarm(): ?int
    {
        return count($this->findBy(['type' => 'Alarm']));
    }

    public function getAlarmDevice()
    {
        return $this->findBy(['type' => 'Alarm']);
    }

    /**
     * Number of Interior Lights Devices 
     *
     * @return integer|null
     */
    public function getNumberOfLightInt(): ?int
    {
        return count($this->findBy(['type' => 'Light', 'appliancespec' => 'Interior']));
    }

    public function getLightIntDevice()
    {
        return $this->findBy(['type' => 'Light', 'appliancespec' => 'Interior']);
    }

    /**
     * Number of Exterior Lights Devices 
     *
     * @return integer|null
     */
    public function getNumberOfLightExt(): ?int
    {
        return count($this->findBy(['type' => 'Light', 'appliancespec' => 'Exterior']));
    }

    public function getLightExtDevice()
    {
        return $this->findBy(['type' => 'Light', 'appliancespec' => 'Exterior']);
    }

    /**
     * Number of Appliance Tv Devices 
     *
     * @return integer|null
     */
    public function getNumberOfTv(): ?int
    {
        return count($this->findBy(['type' => 'Appliance', 'appliancespec' => 'Tv']));
    }

    public function getTvDevice()
    {
        return $this->findBy(['type' => 'Appliance', 'appliancespec' => 'Tv']);
    }

    /**
     * Number of Climate Fan Devices 
     *
     * @return integer|null
     */
    public function getNumberOfFan(): ?int
    {
        return count($this->findBy(['type' => 'Climate', 'appliancespec' => 'Fan']));
    }

    public function getFanDevice()
    {
        return $this->findBy(['type' => 'Climate', 'appliancespec' => 'Fan']);
    }

    /**
     * Number of Climate Clim Devices 
     *
     * @return integer|null
     */
    public function getNumberOfClim(): ?int
    {
        return count($this->findBy(['type' => 'Climate', 'appliancespec' => 'Clim']));
    }

    public function getClimDevice()
    {
        return $this->findBy(['type' => 'Climate', 'appliancespec' => 'Clim']);
    }

    /**
     * Number of Appliance WashMachine Devices 
     *
     * @return integer|null
     */
    public function getNumberOfWashMachine(): ?int
    {
        return count($this->findBy(['type' => 'Appliance', 'appliancespec' => 'Wash Machine']));
    }

    public function getWashMachineDevice()
    {
        return $this->findBy(['type' => 'Appliance', 'appliancespec' => 'Wash Machine']);
    }

    /**
     * Number of Appliance Fridge Devices 
     *
     * @return integer|null
     */
    public function getNumberOfFridge(): ?int
    {
        return count($this->findBy(['type' => 'Appliance', 'appliancespec' => 'Fridge']));
    }

    public function getFridgeDevice()
    {
        return $this->findBy(['type' => 'Appliance', 'appliancespec' => 'Fridge']);
    }
    /**
     * Number of Energy Smart Meter Devices 
     *
     * @return integer|null
     */
    public function getNumberOfEnergySmartMeter(): ?int
    {
        return count($this->findBy(['type' => 'Smart Meter']));
    }

    public function getEnergySmartMeterDevice()
    {
        return $this->findBy(['type' => 'Smart Meter']);
    }

    public function getNumberOfEmergencyBtn(): ?int
    {
        return count($this->findBy(['type' => 'Emergency']));
    }

    public function getEmergencyBtnDevice()
    {
        return $this->findBy(['type' => 'Emergency']);
    }

    public function getNumberOfEachDevice(): ?array
    {

        $tab = [];
        $tab['NbCamera']            = $this->getNumberOfCamera();
        $tab['NbMotionSensor']      = $this->getNumberOfMotionSensor();
        $tab['NbFireSensor']        = $this->getNumberOfFireSensor();
        $tab['NbFloodSensor']       = $this->getNumberOfFloodSensor();
        $tab['NbDoorSensor']        = $this->getNumberOfDoorSensor();
        $tab['NbEmergency']         = $this->getNumberOfEmergencyBtn();
        $tab['NbAlarm']             = $this->getNumberOfAlarm();
        $tab['NbLightInt']          = $this->getNumberOfLightInt();
        $tab['NbLightExt']          = $this->getNumberOfLightExt();
        $tab['NbTv']                = $this->getNumberOfTv();
        $tab['NbFan']               = $this->getNumberOfFan();
        $tab['NbClim']              = $this->getNumberOfClim();
        $tab['NbWashMachine']       = $this->getNumberOfWashMachine();
        $tab['NbEnergySmartMeter']  = $this->getNumberOfEnergySmartMeter();
        $tab['NbFridge']            = $this->getNumberOfFridge();


        return $tab;
    }

    public function getDevices(): ?array
    {

        $tabDevices = [];

        $tabDevices['Camera']      = $this->getCameraDevice();
        $tabDevices['Motion']      = $this->getMotionSensorDevice();
        $tabDevices['Fire']        = $this->getFireSensorDevice();
        $tabDevices['Flood']       = $this->getFloodSensorDevice();
        $tabDevices['Door']        = $this->getDoorSensorDevice();
        $tabDevices['Emergency']   = $this->getEmergencyBtnDevice();
        $tabDevices['Alarm']       = $this->getAlarmDevice();
        $tabDevices['LightInt']    = $this->getLightIntDevice();
        $tabDevices['LightExt']    = $this->getLightExtDevice();
        $tabDevices['Tv']          = $this->getTvDevice();
        $tabDevices['Fan']         = $this->getFanDevice();
        $tabDevices['Clim']        = $this->getClimDevice();
        $tabDevices['WashMachine'] = $this->getWashMachineDevice();
        $tabDevices['Fridge']      = $this->getFridgeDevice();
        $tabDevices['EnergySmartMeter']      = $this->getEnergySmartMeterDevice();

        return $tabDevices;
    }
}

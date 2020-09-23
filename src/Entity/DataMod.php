<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DataModRepository")
 */
class DataMod
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $pmax;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $pmoy;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $qmax;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $qmoy;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $smax;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $smoy;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cosmin;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cosmn;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $vmin;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $vmax;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $vmoy;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $ea;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $er;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $eaindex;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Devices", inversedBy="dataMods")
     * @ORM\JoinColumn(nullable=false)
     */
    private $smartmod;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPmax(): ?float
    {
        return $this->pmax;
    }

    public function setPmax(?float $pmax): self
    {
        $this->pmax = $pmax;

        return $this;
    }

    public function getPmoy(): ?float
    {
        return $this->pmoy;
    }

    public function setPmoy(?float $pmoy): self
    {
        $this->pmoy = $pmoy;

        return $this;
    }

    public function getQmax(): ?float
    {
        return $this->qmax;
    }

    public function setQmax(?float $qmax): self
    {
        $this->qmax = $qmax;

        return $this;
    }

    public function getQmoy(): ?float
    {
        return $this->qmoy;
    }

    public function setQmoy(?float $qmoy): self
    {
        $this->qmoy = $qmoy;

        return $this;
    }

    public function getSmax(): ?float
    {
        return $this->smax;
    }

    public function setSmax(?float $smax): self
    {
        $this->smax = $smax;

        return $this;
    }

    public function getSmoy(): ?float
    {
        return $this->smoy;
    }

    public function setSmoy(?float $smoy): self
    {
        $this->smoy = $smoy;

        return $this;
    }

    public function getCosmin(): ?float
    {
        return $this->cosmin;
    }

    public function setCosmin(?float $cosmin): self
    {
        $this->cosmin = $cosmin;

        return $this;
    }

    public function getCosmn(): ?float
    {
        return $this->cosmn;
    }

    public function setCosmn(?float $cosmn): self
    {
        $this->cosmn = $cosmn;

        return $this;
    }

    public function getVmin(): ?float
    {
        return $this->vmin;
    }

    public function setVmin(?float $vmin): self
    {
        $this->vmin = $vmin;

        return $this;
    }

    public function getVmax(): ?float
    {
        return $this->vmax;
    }

    public function setVmax(?float $vmax): self
    {
        $this->vmax = $vmax;

        return $this;
    }

    public function getVmoy(): ?float
    {
        return $this->vmoy;
    }

    public function setVmoy(?float $vmoy): self
    {
        $this->vmoy = $vmoy;

        return $this;
    }

    public function getEa(): ?float
    {
        return $this->ea;
    }

    public function setEa(?float $ea): self
    {
        $this->ea = $ea;

        return $this;
    }

    public function getEr(): ?float
    {
        return $this->er;
    }

    public function setEr(?float $er): self
    {
        $this->er = $er;

        return $this;
    }

    public function getEaindex(): ?float
    {
        return $this->eaindex;
    }

    public function setEaindex(?float $eaindex): self
    {
        $this->eaindex = $eaindex;

        return $this;
    }

    public function getSmartmod(): ?Devices
    {
        return $this->smartmod;
    }

    public function setSmartmod(?Devices $smartmod): self
    {
        $this->smartmod = $smartmod;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }
}

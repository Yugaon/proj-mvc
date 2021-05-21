<?php

namespace App\Entity;

use App\Repository\ScoreListRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScoreListRepository::class)
 */
class ScoreList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Rundor;

    /**
     * @ORM\Column(type="integer")
     */
    private $vunnit;

    /**
     * @ORM\Column(type="float")
     */
    private $procent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRundor(): ?int
    {
        return $this->Rundor;
    }

    public function setRundor(int $Rundor): self
    {
        $this->Rundor = $Rundor;

        return $this;
    }

    public function getVunnit(): ?int
    {
        return $this->vunnit;
    }

    public function setVunnit(int $vunnit): self
    {
        $this->vunnit = $vunnit;

        return $this;
    }

    public function getProcent(): ?int
    {
        return $this->procent;
    }

    public function setProcent(int $procent): self
    {
        $this->procent = $procent;

        return $this;
    }
}

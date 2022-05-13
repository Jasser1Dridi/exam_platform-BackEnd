<?php

namespace App\Entity;

use App\Repository\ExamenCandidatScoreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExamenCandidatScoreRepository::class)
 */
class ExamenCandidatScore
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $candidat_score;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $candidat;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $examen;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $compagneExamen;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidatScore(): ?int
    {
        return $this->candidat_score;
    }

    public function setCandidatScore(?int $candidat_score): self
    {
        $this->candidat_score = $candidat_score;

        return $this;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?int $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getExamen(): ?Examen
    {
        return $this->examen;
    }

    public function setExamen(?int $examen): self
    {
        $this->examen = $examen;

        return $this;
    }

    public function getCompagneExamen(): ?int
    {
        return $this->compagneExamen;
    }

    public function setCompagneExamen(?int $compagneExamen): self
    {
        $this->compagneExamen = $compagneExamen;

        return $this;
    }
}

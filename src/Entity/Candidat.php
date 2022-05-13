<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;

use App\Repository\CandidatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CandidatRepository::class)
 */
class Candidat extends User
{

    /**
     * @ORM\Column(type="integer")
     */
    private $cin;

    /**
     * @ORM\ManyToMany(targetEntity=Reponse::class, inversedBy="candidats")
     */
    private $Candidat_reponse;

    /**
     * @ORM\ManyToMany(targetEntity=CompagneExamen::class, mappedBy="Condidat_Compagne_De_Examen")
     */
    private $compagneExamens;



    public function __construct()
    {
        $this->Candidat_reponse = new ArrayCollection();
        $this->compagneExamens = new ArrayCollection();
        $this->examens = new ArrayCollection();
    }

    public function serializeCandidat(Candidat $candidat)
    {
        return array(
            'id' => $candidat->getId(),
            'nom' => $candidat->getNom(),
            'email' => $candidat->getEmail(),
            'password' => $candidat->getPassword(),
            'cin'=> $candidat->getCin()
        );
    }


    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getCandidatReponse(): Collection
    {
        return $this->Candidat_reponse;
    }

    public function addCandidatReponse(Reponse $candidatReponse): self
    {
        if (!$this->Candidat_reponse->contains($candidatReponse)) {
            $this->Candidat_reponse[] = $candidatReponse;
        }

        return $this;
    }

    public function removeCandidatReponse(Reponse $candidatReponse): self
    {
        $this->Candidat_reponse->removeElement($candidatReponse);

        return $this;
    }

    /**
     * @return Collection<int, CompagneExamen>
     */
    public function getCompagneExamens(): Collection
    {
        return $this->compagneExamens;
    }

    public function addCompagneExamen(CompagneExamen $compagneExamen): self
    {
        if (!$this->compagneExamens->contains($compagneExamen)) {
            $this->compagneExamens[] = $compagneExamen;
            $compagneExamen->addCondidatCompagneDeExaman($this);
        }

        return $this;
    }

    public function removeCompagneExamen(CompagneExamen $compagneExamen): self
    {
        if ($this->compagneExamens->removeElement($compagneExamen)) {
            $compagneExamen->removeCondidatCompagneDeExaman($this);
        }

        return $this;
    }

}

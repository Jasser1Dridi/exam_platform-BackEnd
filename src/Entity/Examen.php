<?php

namespace App\Entity;

use App\Repository\ExamenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ExamenRepository::class)


 */
class Examen
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $duration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(float $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
    /**
     * @ORM\OneToMany(targetEntity=Questionnaire::class, mappedBy="examen")
     */
    private $Questinnaire;

    /**
     * @ORM\ManyToOne(targetEntity=CompagneExamen::class, inversedBy="examen")
     */
    private $compagneExamen;


    public function __construct()
    {
        $this->Questinnaire = new ArrayCollection();
    }



    /**
     * @return Collection<int, Questionnaire>
     */
    public function getQuestinnaire(): Collection
    {
        return $this->Questinnaire;
    }

    public function addQuestinnaire(Questionnaire $questinnaire): self
    {
        if (!$this->Questinnaire->contains($questinnaire)) {
            $this->Questinnaire[] = $questinnaire;
            $questinnaire->setExamen($this);
        }

        return $this;
    }

    public function removeQuestinnaire(Questionnaire $questinnaire): self
    {
        if ($this->Questinnaire->removeElement($questinnaire)) {
            // set the owning side to null (unless already changed)
            if ($questinnaire->getExamen() === $this) {
                $questinnaire->setExamen(null);
            }
        }

        return $this;
    }

    public function getCompagneExamen(): ?CompagneExamen
    {
        return $this->compagneExamen;
    }

    public function setCompagneExamen(?CompagneExamen $compagneExamen): self
    {
        $this->compagneExamen = $compagneExamen;

        return $this;
    }


}

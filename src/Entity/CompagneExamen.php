<?php

namespace App\Entity;

use App\Repository\CompagneExamenRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=CompagneExamenRepository::class)
 */
class CompagneExamen
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
     * @ORM\Column(type="string")
     */
    private $start_date;

    /**
     * @ORM\Column(type="string")
     */
    private $end_date;

    /**
     * @ORM\OneToMany(targetEntity=Examen::class, mappedBy="compagneExamen")
     */
    private $examen;

    /**
     * @ORM\ManyToMany(targetEntity=Candidat::class, inversedBy="compagneExamens")
     */
    private $Condidat_Compagne_De_Examen;

    public function __construct()
    {
        $this->examen = new ArrayCollection();
        $this->Condidat_Compagne_De_Examen = new ArrayCollection();
    }
public function __toString()
{
return "test";}

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

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function setStartDate(string $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function setEndDate(string $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * @return Collection<int, Examen>
     */
    public function getExamen(): Collection
    {
        return $this->examen;
    }

    public function addExaman(Examen $examan): self
    {
        if (!$this->examen->contains($examan)) {
            $this->examen[] = $examan;
            $examan->setCompagneExamen($this);
        }

        return $this;
    }

    public function removeExaman(Examen $examan): self
    {
        if ($this->examen->removeElement($examan)) {
            // set the owning side to null (unless already changed)
            if ($examan->getCompagneExamen() === $this) {
                $examan->setCompagneExamen(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Candidat>
     */
    public function getCondidatCompagneDeExamen(): Collection
    {
        return $this->Condidat_Compagne_De_Examen;
    }

    public function addCondidatCompagneDeExaman(Candidat $condidatCompagneDeExaman): self
    {
        if (!$this->Condidat_Compagne_De_Examen->contains($condidatCompagneDeExaman)) {
            $this->Condidat_Compagne_De_Examen[] = $condidatCompagneDeExaman;
        }

        return $this;
    }

    public function removeCondidatCompagneDeExaman(Candidat $condidatCompagneDeExaman): self
    {
        $this->Condidat_Compagne_De_Examen->removeElement($condidatCompagneDeExaman);

        return $this;
    }
}

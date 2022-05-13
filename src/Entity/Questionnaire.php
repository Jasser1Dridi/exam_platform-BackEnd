<?php

namespace App\Entity;

use App\Repository\QuestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**

 * @ORM\Entity(repositoryClass=QuestionnaireRepository::class)
 *
 *

 */
class Questionnaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"questionnaire:read", "questionnaire:write"})
     */
    private $question;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"questionnaire:read", "questionnaire:write"})

     */
    private $domaine;

    /**
     * @ORM\Column(type="integer", length=255,nullable=true)
     * @Groups({"questionnaire:read", "questionnaire:write"})

     */
    private $points;

    /**
     * @ORM\Column(type="string", length=255,nullable=false)
     * @Groups({"questionnaire:read", "questionnaire:write"})

     */
    private $managedBy;

    /**
     * @ORM\ManyToOne(targetEntity=Examen::class, inversedBy="Questinnaire")

     */
    private $examen;

    /**
     * @ORM\OneToMany(targetEntity=Reponse::class, cascade={"persist", "remove"}, mappedBy="questionnaire")
     *

     */
    private $Reponse;

    public function __construct()
    {
        $this->Reponse = new ArrayCollection();
    }
    public function __toString()
    {
return "test";    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getPoints(): ?string
    {
        return $this->points;
    }

    public function setPoints(string $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getManagedBy(): ?string
    {
        return $this->managedBy;
    }

    public function setManagedBy(string $managedBy): self
    {
        $this->managedBy = $managedBy;

        return $this;
    }

    public function getExamen(): ?Examen
    {
        return $this->examen;
    }

    public function setExamen(?Examen $examen): self
    {
        $this->examen = $examen;

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponse(): Collection
    {
        return $this->Reponse;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->Reponse->contains($reponse)) {
            $this->Reponse[] = $reponse;
            $reponse->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->Reponse->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestionnaire() === $this) {
                $reponse->setQuestionnaire(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\EntrerpiseRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=EntrerpiseRepository::class)
 */
class Entrerpise extends  User
{

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domaine;



    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }
}

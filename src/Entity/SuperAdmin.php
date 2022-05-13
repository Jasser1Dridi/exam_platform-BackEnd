<?php

namespace App\Entity;

use App\Repository\SuperAdminRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=SuperAdminRepository::class)
 */
class SuperAdmin extends  User
{


}

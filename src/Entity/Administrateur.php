<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministrateurRepository::class)]
class Administrateur extends User
{
  

    public function __construct()
    {
        $this->roles[]="Administrateur";
        // on lui attribue le role admin
        
    }

}

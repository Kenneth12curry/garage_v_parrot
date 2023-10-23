<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HoraireController extends AbstractController
{
    #méthode (fonction) qui permet de charger la page 
    #qui affiche la liste des horaires dans l'espace dédiée de l'admin
    #[Route('/admin/horaire', name: 'app_admin_horaire')]
    public function index(): Response
    {
        return $this->render('user/admin/list_horaire.html.twig', [
            'controller_name' => 'HoraireController',
        ]);
    }


    # méthode (fonction) qui permet d'ajouter des horaires 
    #depuis l'espace dédiée de l'admin
    #[Route('/admin/add/horaire', name: 'app_admin_add_horaire')]
    public function addhoraire(): Response
    {
        return $this->render('user/admin/add_horaire.html.twig', [
            'controller_name' => 'HoraireController',
        ]);
    }
}

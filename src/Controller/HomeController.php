<?php

namespace App\Controller;

use App\Repository\AvisRepository;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    #[Route('/home', name: 'app_home')]
    public function index(VehiculeRepository $vehiculeRepository,AvisRepository $avisRepository): Response
    {
        $datas=$vehiculeRepository->findAll();
        $avis=$avisRepository->findDistinctAvisAcceptes();
        return $this->render('home/index.html.twig', [
            "datas" => $datas,
            'datasA' => $avis,
            'controller_name' => 'HomeController',
        ]);
    }
}

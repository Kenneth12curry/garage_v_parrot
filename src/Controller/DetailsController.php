<?php

namespace App\Controller;

use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailsController extends AbstractController
{
    #[Route('/details/{idVehicule}', name: 'app_details')]
    public function index($idVehicule,VehiculeRepository $vehiculeRepository): Response
    {

        $vehicule=$vehiculeRepository->findOneBy(["id"=>$idVehicule]);
        return $this->render('details/index.html.twig', [
            "vehicule"=>$vehicule,
            'controller_name' => 'DetailsController',
        ]);
    }

}

<?php

namespace App\Controller;

use App\Repository\HoraireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    #[Route('/footer', name: 'app_footer')]
    public function index(HoraireRepository $horaireRepository): Response
    {
        $datasH=$horaireRepository->findAll();
        return $this->render('partials/footer.html.twig', [
            'datasH'=>$datasH,
            'controller_name' => 'FooterController',
        ]);
    }

}

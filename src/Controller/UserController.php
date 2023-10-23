<?php

namespace App\Controller;

use App\Repository\EmployeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/admin/liste/emp/', name: 'app_admin_user')]
    public function index(EmployeRepository $employeRepository): Response
    {

        $datas=$employeRepository->findAll();
        return $this->render('user/admin/list_employe.html.twig', [
            "datas" => $datas,
            'controller_name' => 'UserController',
        ]);
    }

   
}

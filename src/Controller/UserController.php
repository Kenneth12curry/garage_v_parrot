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


    #méthode pour supprimer un compte employé
    #[Route('/emp/destroy/{idEmp}', name: 'app_destroy_emp',methods:["GET"])]
    public function destroy($idEmp,EmployeRepository $employeRepository): Response
    {
        //récupération de l'employé à pértir de l'id
        $emp=$employeRepository->find($idEmp);
        //Appel de la méthode remove qui se trouve dans AvisRepository
        $employeRepository->remove($emp,true);
        //redirection vers la liste des demandes (employés)
        return $this->redirectToRoute('app_admin_user');

    }

   
}

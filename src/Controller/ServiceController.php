<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    
    #[Route('/service', name: 'app_service')]
    public function index(ServiceRepository $serviceRepository): Response
    {
        $datas = $serviceRepository->findAll();
        return $this->render('services/page_service.html.twig', [
            'datas' => $datas,
            'controller_name' => 'ServiceController',
        ]);
    }


    #[Route('/admin/service', name: 'app_admin_service')]
    public function service(ServiceRepository $serviceRepository): Response
    {
        $datas=$serviceRepository->findAll();
        return $this->render('user/admin/list_service.html.twig', [
            'datas' => $datas,
            'controller_name' => 'ServiceController',
        ]);
    }


    #[Route('/admin/add/service', name: 'app_add_service')]
    public function addService(Request $request,ServiceRepository $serviceRepository): Response
    {
        $errors=[];
        // Si l'utilisateur clique sur le bouton enrgistrer du formulaire
        if($request->request->has("btnSave")){

            $nom=$request->request->get("nomService");
            $description=$request->request->get("descriptionService");
            $categorie=$request->request->get("categorieService");
        
            //Validation
            if(empty($nom)){
                $errors['nom']="Le nom du service est obligatoire";
            }
            if(empty($description)){
                $errors['description']="La description du service est obligatoire";
            }
            if(empty($categorie)){
                $errors['categorie']="La catégorie du service est obligatoire";
            }
            
            // Si des erreurs sont présentes, on les affiche
            if(count($errors)!=0){

                return $this->render('user/admin/add_service.html.twig', [
                    'controller_name' => 'ServiceController',
                    'errors' => $errors,
                ]);

            }

            if(trim($request->request->get("btnSave"))=='create'){
                //Création de l'objet de type Service
                $service=new Service;
    
            }else{

                //récupérer l'id du service  qui se trouve dans le champ caché
                $id=$request->request->get('id');
                $service=$serviceRepository->find($id);
                //dd($service);
                
            }
            
            //Donner des états aux attributs avec les setters
            $service->setNomService($nom);
            $service->setDescription($description);
            $service->setCategorie($categorie);
            //Appel de la méthode save qui se trouve dans VehiculeRepository
            $serviceRepository->save($service,true);
            //redirection vers la liste des services (admin)
            return $this->redirectToRoute('app_admin_service');
        } 
       
        return $this->render('user/admin/add_service.html.twig', [
            'errors' => $errors,
            'controller_name' => 'ServiceController',
        ]);

    }

    #[Route('/admin/edit/service/{idService}', name: 'app_edit_service', methods:["GET"])]
    public function update($idService,ServiceRepository $serviceRepository):Response{

        # variable qui contient la liste des erreurs
        $errors=[];
        $service = $serviceRepository->findOneBy(['id' => $idService]);
        return $this->render('user/admin/add_service.html.twig', [
            "service" => $service,
            'errors' => $errors,
            'controller_name' => 'ServiceController',
        ]);

    }

      //méthode pour supprimer un service
      #[Route('/admin/service/destroy/{idService}', name: 'app_destroy_service',methods:["GET"])]
      public function destroy($idService,ServiceRepository $serviceRepository): Response
      {
  
          //récupération de la l'id du service
          $service=$serviceRepository->find($idService);
          //Appel de la méthode remove qui se trouve dans ServiceRepository
          $serviceRepository->remove($service,true);
          //redirection vers la liste des services (admin)
          return $this->redirectToRoute('app_admin_service');

      }
  
  

}

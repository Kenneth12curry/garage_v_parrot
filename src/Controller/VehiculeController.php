<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehiculeController extends AbstractController
{


    # méthode de pagination
    private function handlePaginationRequest(Request $request, VehiculeRepository $vehiculeRepository, string $template,int $limit): Response
    {
        $page = $request->query->getInt('page', 1);
        //$limit = 10;

        $entityManager = $this->getDoctrine()->getManager();
        $vehiculeRepository = $entityManager->getRepository(Vehicule::class);

        $totalVehicules = count($vehiculeRepository->findAll());
        $maxPages = ceil($totalVehicules / $limit);

        $offset = ($page - 1) * $limit;
        $vehicules = $vehiculeRepository->findBy([], [], $limit, $offset);

        return $this->render($template, [
            'vehicules' => $vehicules,
            'page' => $page,
            'maxPages' => $maxPages,
        ]);
    }


    # méthode qui charge la page cars du site web 
    #[Route('/cars', name: 'app_cars')]
    public function index(Request $request,VehiculeRepository $vehiculeRepository): Response
    {
       return $this->handlePaginationRequest($request,$vehiculeRepository,'cars/page_cars.html.twig',10);  
    }

    # méthode qui charge la page qui affiche la liste
    # des véhicules au niveau de l'espace  d'administration de l'employé
    #[Route('/emp/vehicule', name: 'app_emp_vehicule')]
    public function show(Request $request, VehiculeRepository $vehiculeRepository): Response
    {
        return $this->handlePaginationRequest($request,$vehiculeRepository,'user/employe/vehicule.html.twig',5);
    }


    # méthode qui charge la page qui permet d'ajouter ou de modifier
    # des véhicules depuis l'espace  d'administration de l'employé
    #[Route('/emp/add/vehicule', name: 'app_emp_add_vehicule')]
    public function addVehicule(Request $request, VehiculeRepository $vehiculeRepository): Response
    {
        
        $errors=[];
        // Si l'utilisateur clique sur le bouton enrgistrer du formulaire
        if($request->request->has("btnSave")){

            $nom=$request->request->get("nomVehicule");
            $prix=($request->request->get("prixVehicule"));
            $image=$request->request->get("imageVehicule");
            $annee=$request->request->get("anneeVehicule");
            $kilometrage=$request->request->get("anneeVehicule");
            $marque=$request->request->get("marqueVehicule");

           //Validation => vérification
            if(empty($nom)){
                $errors['nom']="Le nom du véhicule est obligatoire";
            }
            if(empty($prix)){
                $errors['prix']="Le prix du véhicule est obligatoire";
            }
            if(empty($image)){
                $errors['image']="L'image du véhiclule est obligatoire";
            }
            if(empty($annee)){
                $errors['annee']="L'année du véhicule est obligatoire";
            }
            if(empty($kilometrage)){
                $errors['kilometrage']="Le kilométrage  du véhicule est obligatoire";
            }
            if(empty($marque)){
                $errors['marque']="La marque du véhicule est obligatoire";
            }
            
            // Si des erreurs sont présentes, on les affiche
            if(count($errors)!=0){
                return $this->render('user/employe/add_vehicule.html.twig', [
                    'errors' => $errors,
                ]);
            }
            

            if(trim($request->request->get("btnSave"))=='create'){
                //Création de l'objet de type Véhicule
                $vehicule=new Vehicule;
    
            }else{

                //récupérer l'id du véhicule  qui se trouve dans le champ caché
                $id=$request->request->get('id');
                $vehicule=$vehiculeRepository->find($id);

            }
            
            //Donner des états aux attributs avec les setters
            $vehicule->setNom($nom);
            $vehicule->setPrix($prix);
            $vehicule->setImage($image);
            $vehicule->setAnnee($annee);
            $vehicule->setKilometrage($kilometrage);
            $vehicule->setMarque($marque);
            //Appel de la méthode save qui se trouve dans VehiculeRepository
            $vehiculeRepository->save($vehicule,true);
            //redirection vers la liste des véhicules
            return $this->redirectToRoute('app_emp_vehicule');
        } 
       
        return $this->render('user/employe/add_vehicule.html.twig', [
            'errors' => $errors,
            'controller_name' => 'ServiceController',
        ]);
    

    }


    
    # méthode pour modifer un véhicule 
    #[Route('/emp/edit/vehicule/{idVehicule}', name: 'app_emp_edit_vehicule', methods: ["GET"])]
    public function update(Request $request, $idVehicule, VehiculeRepository $vehiculeRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 10;
        
        $entityManager = $this->getDoctrine()->getManager();
        $vehiculeRepository = $entityManager->getRepository(Vehicule::class);
        
        $totalVehicules = count($vehiculeRepository->findAll());
        $maxPages = ceil($totalVehicules / $limit);
        
        $offset = ($page - 1) * $limit;

        $vehicules = $vehiculeRepository->findBy([], [], $limit, $offset);
        
        $vehicule = $vehiculeRepository->findOneBy(['id' => $idVehicule]);
        
        return $this->render('user/employe/add_vehicule.html.twig', [
            'vehicules' => $vehicules,
            'page' => $page,
            'maxPages' => $maxPages,
            'vehicule' => $vehicule
        ]);

    }

    # méthode pour le filtre des véhicules
    #[Route('/vehicules/filtre', name: 'app_vehicules_filtre')]
    public function filtrerVehicules(Request $request, VehiculeRepository $vehiculeRepository): Response
    {
        //$filtre = $request->query->get('filtre'); 
        $nomV=$request->request->get("filtre");// Récupère le paramètre 'filtre' d

        if($nomV==null){
            return $this->redirectToRoute('app_cars');
        }
           
        
        // Utilisez $nomV pour filtrer la liste des véhicules
        $vehicules = $vehiculeRepository->findByFirstVehicule($nomV);

        return $this->render('cars/page_cars.html.twig', [
                'vehicules' => $vehicules
        ]);
       
    }


}

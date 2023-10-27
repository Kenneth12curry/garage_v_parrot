<?php

namespace App\Controller;

use App\Entity\Horaire;
use App\Repository\HoraireRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HoraireController extends AbstractController
{
    #méthode (fonction) qui permet de charger la page 
    #qui affiche la liste des horaires dans l'espace dédiée de l'admin
    #[Route('/admin/horaire', name: 'app_admin_horaire')]
    public function index(HoraireRepository $horaireRepository): Response
    {
        $datas=$horaireRepository->findAll();
        return $this->render('user/admin/list_horaire.html.twig', [
            'datas' => $datas,
            'controller_name' => 'HoraireController',
        ]);
    }


    # méthode (fonction) qui permet d'ajouter des horaires 
    #depuis l'espace dédiée de l'admin
    #[Route('/admin/add/horaire', name: 'app_admin_add_horaire')]
    public function addhoraire(Request $request, HoraireRepository $horaireRepository): Response
    {
        $errors=[];
        $message="";
        // Si l'utilisateur clique sur le bouton enrgistrer du formulaire
        if($request->request->has("btnSave")){

            $jour=$request->request->get("jour");
            $heureOuverture= DateTime::createFromFormat('H:i',$request->request->get("HeureOuverture"));
            $heureFermeture= DateTime::createFromFormat('H:i',$request->request->get("HeureFermeture"));
            
            //Validation
            if(empty($jour)){
                $errors['jour']="La sélection du jour est obligatoire";
            }
            if(empty($heureOuverture)){
                $errors['heureOuverture']="l'heure d'ouverture est obligatoire";
            }
            if(empty($heureFermeture)){
                $errors['heureFermeture']="l'heure de fermeture est obligatoire";
            }
            
            // Si des erreurs sont présentes, on les affiche
            if(count($errors)!=0){
                return $this->render('user/admin/add_horaire.html.twig', [
                    'errors' => $errors,
                ]);

            }

            if(trim($request->request->get("btnSave"))=='create'){
                //Création de l'objet de type Horaire
                $horaire=new Horaire;
    
            }else{

                //récupérer l'id de l'horaire  qui se trouve dans le champ caché
                $id=$request->request->get('id');
                $horaire=$horaireRepository->find($id);    
                
            }
           
            //Donner des états aux attributs avec les setters
            $horaire->setJour($jour);
            if ($heureOuverture > $heureFermeture) {
                $message = "L'heure d'ouverture doit être inférieur à l'heure de fermeture.";
            } elseif($heureOuverture === $heureFermeture) {
                $message =  "Les heures d'ouverture et de fermeture sont identiques.";
            }else{
               
                $horaire->setHeureOuverture($heureOuverture);
                $horaire->setHeureFermeture($heureFermeture);
            
            }
            //Appel de la méthode save qui se trouve dans HoraireeRepository
            //Insérer l'objet dans la base de données
            $horaireRepository->save($horaire,true);
            //redirection vers la liste des horaires (admin)
            return $this->redirectToRoute('app_admin_horaire');
        } 

        return $this->render('user/admin/add_horaire.html.twig', [
            'errors' => $errors,
            'message'=>$message,
            'controller_name' => 'HoraireController',
        ]);

    }

    // methode pour modiffier un horaire
    #[Route('/admin/edit/horaire/{idHoraire}', name: 'app_edit_horaire', methods:["GET"])]
    public function updateHoraire($idHoraire,HoraireRepository $horaireRepository):Response{

        
        $horaire = $horaireRepository->findOneBy(['id' => $idHoraire]);
        //passer l'objet de type Horaire dans la vue qui permet l'ajout d'un horaire
        return $this->render('user/admin/add_horaire.html.twig', [
            "horaire" => $horaire,
        ]);

    }   


}

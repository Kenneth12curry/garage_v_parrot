<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AvisController extends AbstractController
{

    public function handleAddAvis(Request $request,AvisRepository $avisRepository,TokenStorageInterface $tokenStorage = null,$template): Response
    {
        // Récupérer l'utilisateur courant
        $user = $tokenStorage->getToken() ? $tokenStorage->getToken()->getUser() : null;

        $errors=[];
        //Traitement du formulaire
        // Si l'utilisateur clique sur le bouton enregistrer du formulaire
        if($request->request->has("btnSave")){

            $nomClient=$request->request->get("nomClient");
            $commentaire=$request->request->get("commentaire");
            $etat=$request->request->get("etat");
            $note=$request->request->get("note");

            //Validation => vérification
            if(empty($nomClient)){
                $errors['nomClient']="Le nom du client est obligatoire";
            }
            if(empty($commentaire)){
                $errors['commentaire']="Le commentaire est obligatoire";
            }
            if(empty($note)){
                $errors['note']="La note est obligatoire";
            }
            if(count($errors)!=0){
                
                return $this->render($template, [
                    'errors' => $errors,
                ]);
            }

            if(trim($request->request->get("btnSave"))=='create'){
                //Création de l'objet de type Avis
                $avis=new Avis;
    
            }
            
            //Donner des états aux attributs avec les setters
            $avis->setNom($nomClient);
            $avis->setCommentaire($commentaire);
            $avis->setNote($note);

            if ($user !== null) {
                // L'utilisateur est authentifié, vous pouvez utiliser $user ici
                $avis->setEmploye($user);
                // setters => setEtat()
                $avis->setEtat($etat);
                //Appel de la méthode save qui se trouve dans AvisRepository
                $avisRepository->save($avis,true);
                //redirection vers la liste des avis
                return $this->redirectToRoute('app_emp_avis');

            } else {

                //Appel de la méthode save qui se trouve dans AvisRepository
                $avisRepository->save($avis,true);
                $message = 'Votre avis a bien été reçu. Merci pour vos suggestions.';
                return $this->render($template, ['message' => $message]);

            }
         
        }

        return $this->render($template, [
            'errors' => $errors,
            'controller_name' => 'AvisController',
        ]);

    }


    #méthode qui charge la page  qui contient la lsite des avis coté employé 
    #[Route('/emp/avis', name: 'app_emp_avis')]
    public function avis(AvisRepository $avisRepository): Response
    {
        $datas=$avisRepository->findAll();
        return $this->render('user/employe/avis.html.twig', [
            'datas'=> $datas,
            'controller_name' => 'AvisController',
        ]);
    }

    #méthode d'ajout de l'avis côté employé
    #[Route('/emp/add/avis', name: 'app_add_avis')]
    public function addAvis(Request $request,AvisRepository $avisRepository,TokenStorageInterface $tokenStorage): Response
    {
        return $this->handleAddAvis($request,$avisRepository,$tokenStorage,'user/employe/add_avis.html.twig');
    }

    #méthode d'ajout de l'avis coté visiteur => site web
    #[Route('/add/notice', name: 'app_add_notice')]
    public function create(Request $request,AvisRepository $avisRepository,TokenStorageInterface $tokenStorage): Response
    {
        return $this->handleAddAvis($request,$avisRepository,$tokenStorage,'avis/page_avis.html.twig');
    }

   

     #méthode qui permet la modification d'un avis
    #[Route('/emp/avis/update/{idAvis}', name: 'app_update_avis',methods:["GET"])]
    public function update($idAvis,AvisRepository $avisRepository): Response
    {
    
        //récupération de l'avis à prtir de l'id
        $avis=$avisRepository->find($idAvis);
        # strcasecmp() => méthode pour comparer deux chaines de caractères
        if(strcasecmp($avis->getEtat(),'Refusée') == 0){
            // modifier l'état de l'avis
            $avis->setEtat("Accepté");
            //push dans la bd
            $avisRepository->save($avis,true);
        }
        //redirection vers la liste des avis
        return $this->redirectToRoute('app_emp_avis');

    }

    #méthode de suppresion d'un avis
    #[Route('/emp/avis/destroy/{idAvis}', name: 'app_destroy_avis',methods:["GET"])]
    public function destroy($idAvis,AvisRepository $avisRepository): Response
    {

        //récupération de l'avis à prtir de l'id
        $avis=$avisRepository->find($idAvis);
        //Appel de la méthode remove qui se trouve dans AvisRepository
        $avisRepository->remove($avis,true);
        //redirection vers la liste des demandes (employés)
        return $this->redirectToRoute('app_emp_avis');

    }
   

}

<?php

namespace App\Controller;

use App\Entity\ContactForm;
use App\Repository\ContactFormRepository;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    # méthode pour charger la page contact du site web
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request,ContactFormRepository $contactFormRepository): Response
    {
       // Si l'utilisateur clique sur le bouton enregistrer du formulaire
        if($request->request->has("btnSave")){

            $sujet=$request->request->get("sujet");
            $nom=$request->request->get("nom");
            $prenom=$request->request->get("prenom");
            $email=$request->request->get("email");
            $tel=$request->request->get("tel");
            $message=$request->request->get("message");

            if(trim($request->request->get("btnSave"))=='create'){
                //Création de l'objet de type form
                $contact=new ContactForm();

            }

            //Donner des états aux attributs avec les setters
            $contact->setSujet($sujet);
            $contact->setNom($nom);
            $contact->setPrenom($prenom);
            $contact->setEmail($email);
            $contact->setTel($tel);
            $contact->setMessage($message);
            //Appel de la méthode save qui se trouve dans ContactFormRepository
            $contactFormRepository->save($contact,true);
            //message
            $message="Merci de nous avoir contacter ! Nous reviendrons vers vous dans les meilleurs délais.";
            return $this->render('contact/index.html.twig',["message" => $message]);
            
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    public function handleAjout(Request $request,ContactFormRepository $contactFormRepository,$template):Response
    {
         // Si l'utilisateur clique sur le bouton enregistrer du formulaire
         if($request->request->has("btnSave")){

            $sujet=$request->request->get("sujet");
            $nom=$request->request->get("nom");
            $prenom=$request->request->get("prenom");
            $email=$request->request->get("email");
            $tel=$request->request->get("tel");
            $message=$request->request->get("message");

            if(trim($request->request->get("btnSave"))=='create'){
                //Création de l'objet de type form
                $contact=new ContactForm();
    
            }

            //Donner des états aux attributs avec les setters
            $contact->setSujet($sujet);
            $contact->setNom($nom);
            $contact->setPrenom($prenom);
            $contact->setEmail($email);
            $contact->setTel($tel);
            $contact->setMessage($message);
            //Appel de la méthode save qui se trouve dans ContactFormRepository
            $contactFormRepository->save($contact,true);
            
        }
        return $this->redirectToRoute($template);

       
    }


    # méthode qui permet d'effectuer une demande à travers le formulaire d'ajout
    #du site web
    #[Route('/add/c/contact', name: 'app_add_c_contact')]
    public function addContact(Request $request,ContactFormRepository $contactFormRepository): Response
    {
       return $this->handleAjout($request,$contactFormRepository,'app_cars');
    }


    # méthode pour charger la liste des demandes sur la page demande_clients
    # au niveau de l'espace d'administration de l'employé
    #[Route('/emp/contact/clients', name: 'app_emp_contact_clients')]
    public function showContactClients(ContactFormRepository $contactFormRepository): Response
    {
        
        $datas=$contactFormRepository->findAll();
        return $this->render('user/employe/demande_clients.html.twig', [
            'datas' => $datas,
            'controller_name' => 'ContactController',
        ]);
       
    }

    #methode de suppression d'une demande client
    #[Route('/emp/demande/destroy/{idDemande}', name: 'app_destroy_demande',methods:["GET"])]
    public function destroy($idDemande,ContactFormRepository $contactFormRepository): Response
    {

        //récupération de la demande à partir de l'id
        $demande=$contactFormRepository->find($idDemande);
        //Appel de la méthode remove qui se trouve dans ContactFormRepository
        $contactFormRepository->remove($demande,true);
        //redirection vers la liste des demandes (employés)
        return $this->redirectToRoute('app_emp_contact_clients');

    }


}

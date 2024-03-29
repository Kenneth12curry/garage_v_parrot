<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

class SecurityController extends AbstractController 
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }


    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    
    /* #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {

        // Nettoyer la session
        $this->get('session')->invalidate();

       
    }*/

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(Request $request): Response
    {
        // Supprimez les données de l'utilisateur de la session
        $request->getSession()->remove('user');

        // Récupérez la variable globale 'user' de l'environnement Twig
        $userGlobal = $this->twig->getGlobals()['user'];

        $userGlobal=null;
    
        /** Redirigez l'utilisateur après la déconnexion */
        return $this->redirectToRoute('home'); // Remplacez 'home' par le nom de la route vers laquelle vous souhaitez rediriger après la déconnexion

    }
   


}

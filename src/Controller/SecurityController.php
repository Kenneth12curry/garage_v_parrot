<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController 
{
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

    #[Route(path: '/logout/decon', name: 'app_logout')]
    public function logout(Security $security, TokenStorageInterface $tokenStorage)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = $security->getUser();

        // Si un utilisateur est authentifié, le déconnecter
        if ($user) {
            $token = $tokenStorage->getToken();
            $token->setAuthenticated(false);
            $tokenStorage->setToken(null);

            $this->get('session')->invalidate(); // Détruire la session
        }

        // Rediriger ou effectuer toute autre action après la déconnexion
        $response = new Response();
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $this->redirectToRoute('app_home');

    }

   


}

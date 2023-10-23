<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\CompteUserFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/user/compte', name: 'app_add_compte')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        //création d'un utilisateur de type Employe
        $emp = new Employe();
        $form = $this->createForm(CompteUserFormType::class, $emp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $emp->setPassword(
                $userPasswordHasher->hashPassword(
                    $emp,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($emp);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $emp,
                $authenticator,
                $request
            );
        }

        return $this->render('user/admin/add_compte.html.twig', [
            'CompteUserForm' => $form->createView(),
        ]);
    }
}

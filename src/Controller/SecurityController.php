<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            // Ajouter un message flash avec le nom de l'utilisateur et ses rôles
            $this->addFlash('success', sprintf(
                'Bienvenue %s %s ! Vous êtes connecté comme étant : %s',
                $this->getUser()->getFirstName(),
                $this->getUser()->getLastName(),
                implode(', ', $this->getUser()->getRoles())
            ));            
            return $this->redirectToRoute('app_home'); // Redirige vers la page home si l'utilisateur est déjà connecté
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', 
        ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

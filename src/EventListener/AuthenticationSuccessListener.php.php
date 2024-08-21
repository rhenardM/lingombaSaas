<?php


// src/EventListener/AuthenticationSuccessListener.php

namespace App\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticationSuccessListener
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $roles = $user->getRoles();

        // Vérifier le rôle de l'utilisateur et rediriger en conséquence
        if (in_array('ROLE_SUPER_ADMIN', $roles, true)) {
            $response = new RedirectResponse($this->router->generate('super_admin'));
        } elseif (in_array('ROLE_ADMIN', $roles, true)) {
            $response = new RedirectResponse($this->router->generate('admin'));
        } elseif (in_array('ROLE_CLIENT', $roles, true)) {
            $response = new RedirectResponse($this->router->generate('client'));
        } else {
            $response = new RedirectResponse($this->router->generate('app_home'));
        }

        $event->getRequest()->getSession()->set('_security.main.target_path', $response->getTargetUrl());
    }
}

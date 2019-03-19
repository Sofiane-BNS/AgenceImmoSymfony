<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {

    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils) {
        //AuthenticationUtils classe qui fournit des outilis comme recuperer les messages d'erreurs d'authentification
        $lastUsername= $authenticationUtils->getLastUsername(); // Permet de recuperer le dernier nom d'utilisateur tapé par lui-même
        $error=$authenticationUtils->getLastAuthenticationError();

        return $this->render('security/login.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

}
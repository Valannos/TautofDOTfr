<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tautof\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller {

    public function loginAction(Request $req) {

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('tautof_platform_homepage');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('TautofUserBundle:Security:login.html.twig', array(
                    'last_username' => $authenticationUtils->getLastUserName(),
                    'error' => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

}

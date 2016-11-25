<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tautof\UserBundle\Controller;


use Tautof\UserBundle\Form\UserType;
use Tautof\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class RegistrationController extends Controller {
    
    public function registrerAction(Request $req) {
        
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $password = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(array('ROLE_USER'));
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $container = $this->container->get('mailer');
            
            return $this->render('TautofUserBundle:Security:login.html.twig');
            
            
        }
        
        return $this->render('TautofUserBundle:Security:registrer.html.twig', array('form' => $form->createView()));
    }
    
    
}
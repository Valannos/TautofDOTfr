<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tautof\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tautof\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class UserController extends Controller {
    
    /**
     * @Security("has_role('ROLE_ADMIN')")
     * 
     */
    
    
    public function deleteAction($user_id) {
        
        $repository = $this->getDoctrine()->getRepository('TautofUserBundle:User');
        $repository->deleteUserById($user_id);
        return $this->redirectToRoute('tautof_user_index');
        
    }
    /**
     *@Security("has_role('ROLE_ADMIN')")
     * 
     */
    
    public function indexAction() {
        
        $allUser = $this->getDoctrine()->getManager()->getRepository('TautofUserBundle:User')->findAll();
        
        return $this->render('TautofUserBundle:User:indexUser.html.twig', array('users' => $allUser));
        
    }
    
    
    
    
    
    
    
}
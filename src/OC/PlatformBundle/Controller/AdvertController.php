<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use OC\PlatformBundle\Entity\Advert;


class AdvertController extends Controller {
    
    public function indexAction($name, $age, Request $req) {
       
        
        $session = new Session();
        $session->migrate();
       
        //$session->get('userName');
        $session->set('userName', 'Toto');
        $session->set('nickname', 'sloubi');
        
        $tag = $req->query->get('tag');
        return $this->render('OCPlatformBundle:Default:index.html.twig', array('name'=>$name, 'age'=>$age, 'tag'=>$tag));
        
    }
    public function redirectWelcomeAction() {
        
       $doctrine = $this->getDoctrine();
       $em = $doctrine->getManager();
       
        
       return $this->render('OCPlatformBundle:Default:welcome.html.twig');
        
        
    }
    public function addAction() {
        
        $advert = new Advert();
        $advert->setTitle('Help Wanted for Symfony !');
        $advert->setAuthor('Jean-Michel PC');
        $advert->setContent('Tu vas bouffer du Symfony !! ');
        
        $date = new \DateTime();
        $advert->setDate($date);
        $advert->setPublished('1');
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($advert);
        $em->flush();
        
        return $this->render('OCPlatformBundle:Default:add.html.twig', array('id' => $advert->getId(), 'title' => $advert->getTitle()));
        
        
        
        
    }
    public function viewAction() {
        
      $repository = $this->getDoctrine()->getManager()->getRepository('OCPlatformBundle:Advert');
      
        
        $advert = $repository->find(33);
        $allAdvert = $repository->findAll();
       
        return $this->render('OCPlatformBundle:Default:index.html.twig', array('allAdvert' => $allAdvert));
        
    }
    
    
}

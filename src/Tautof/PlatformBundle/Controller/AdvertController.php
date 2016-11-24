<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tautof\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Tautof\PlatformBundle\Entity\Advert;
use Tautof\PlatformBundle\Form\AdvertFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Tautof\PlatformBundle\Entity\Make;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AdvertController extends Controller {

    public function indexAction(Request $req) {

        #GETTING FIELDS FROM REQUEST#   

        $make_id = $req->get('make');
        $model_id = $req->get('model');
        $color = $req->get('color');



        $em = $this->getDoctrine()->getManager();
//        $make = $em->getRepository('TautofPlatformBundle:Make')->find($make_id);


        if (!$model_id || $model_id == -1) {

//            $models = $em->getRepository('TautofPlatformBundle:Model')->findBy(array('make' => $make));
            $adverts = $em->getRepository('TautofPlatformBundle:Advert')->getAdvertByMake($make_id);

            //findBy(array('model' => $models));
            return $this->render('TautofPlatformBundle:Advert:index.html.twig', array('Advert' => $adverts));
        } else {

            // $model = $em->getRepository('TautofPlatformBundle:Model')->find($model_id);
            $adverts = $em->getRepository('TautofPlatformBundle:Advert')
                    ->getAdvertByModel($model_id);

            //->findBy(array('model' => $model));

            return $this->render('TautofPlatformBundle:Advert:index.html.twig', array('Advert' => $adverts));
        }
    }

    public function newAction(Request $request) {

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_AUTEUR')) {

            throw new AccessDeniedException('Accès limité aux auteurs');
        }

        $advert = new Advert();
        $form = $this->createForm(AdvertFormType::class, $advert);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $advert = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($advert);
            $em->flush();
            $isPublished = true;
        } else {
            return $this->render('TautofPlatformBundle:Advert:new.html.twig', array('advertForm' => $form->createView()));
            $isPublished = false;
        }
        return $this->render('TautofPlatformBundle:Advert:add.html.twig', array('isPublished' => $isPublished));
    }

    public function homeAction($make_id) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TautofPlatformBundle:Make');
        $allMakes = $repo->findAll();
        $allColors = $em->getRepository('TautofPlatformBundle:Color')->findAll();

        # MODEL AND/OR MAKE #

        if ($make_id == -1) {

            # ONLY MAKE #

            return $this->render('TautofPlatformBundle:Advert:homepage.html.twig', array('allMakes' => $allMakes, 'models' => NULL, 'colors' => $allColors, 'current_make_id' => $make_id));
        } else {

            # MODEL AND MAKE # 

            $currentMake = $repo->find($make_id);
            $models = $em->getRepository('TautofPlatformBundle:Model')->findBy(array('make' => $currentMake));
            //JSON
//            $normalizer = new ObjectNormalizer();
//            $normalizer->setIgnoredAttributes(['make']);
//            $serializer = new Serializer([$normalizer, [new JsonEncoder()] ]);
//            $json = $serializer->serialize(array('models' => $models), 'json');
//            $response = new Response('$json');
//            $response->headers->set('Content-Type', 'application/json');
//            return $response;
            
            //  var_dump($model);
                 return $this->render('TautofPlatformBundle:Advert:homepage.html.twig', array('allMakes' => $allMakes, 'models' => $models, 'current_make_id' => $make_id, 'colors' => $allColors));
        }
    }

    public function testAction($id) {

        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('TautofPlatformBundle:Advert');

        $adverts = $repository->getAdvertByMake($id);

        return $this->render('TautofPlatformBundle:Advert:index.html.twig', array('Advert' => $adverts));
    }

}

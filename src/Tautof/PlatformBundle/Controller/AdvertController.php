<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tautof\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tautof\PlatformBundle\Entity\Advert;
use Tautof\PlatformBundle\Form\AdvertFormType;
use Tautof\PlatformBundle\Form\EditAdvertFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Tautof\PlatformBundle\Entity\Make;
use Tautof\PlatformBundle\Entity\Model;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AdvertController extends Controller {

    public function indexAction(Request $req, $isDeleted) {

        #GETTING FIELDS FROM REQUEST#   

        $make_id = $req->get('make');
        $model_id = $req->get('model');
        $color = $req->get('color');



        $em = $this->getDoctrine()->getManager();
//        $make = $em->getRepository('TautofPlatformBundle:Make')->find($make_id);
        if ((!$make_id || $make_id == -1)) {

            $adverts = $em->getRepository('TautofPlatformBundle:Advert')->findAll();
            return $this->render('TautofPlatformBundle:Advert:index.html.twig', array('Advert' => $adverts, 'isDeleted' => $isDeleted));
        }


        if (!$model_id || $model_id == -1) {

//            $models = $em->getRepository('TautofPlatformBundle:Model')->findBy(array('make' => $make));
            $adverts = $em->getRepository('TautofPlatformBundle:Advert')->getAdvertByMake($make_id);

            //findBy(array('model' => $models));
            return $this->render('TautofPlatformBundle:Advert:index.html.twig', array('Advert' => $adverts, 'isDeleted' => $isDeleted));
        } else {

            // $model = $em->getRepository('TautofPlatformBundle:Model')->find($model_id);
            $adverts = $em->getRepository('TautofPlatformBundle:Advert')
                    ->getAdvertByModel($model_id);

            //->findBy(array('model' => $model));

            return $this->render('TautofPlatformBundle:Advert:index.html.twig', array('Advert' => $adverts, 'isDeleted' => $isDeleted));
        }
    }

    public function newAction(Request $request, $make_id) {

        if (!$this->get('security.authorization_checker')->isGranted('ROLE_AUTEUR')) {

            throw new AccessDeniedException('Accès limité aux auteurs');
        }

        $advert = new Advert();
        $form = $this->createForm(AdvertFormType::class, $advert);

        if ($make_id != -1) {


            $make = $this->getDoctrine()->getManager()->getRepository('TautofPlatformBundle:Make')->find($make_id);

            $models = $this->getDoctrine()->getManager()->getRepository('TautofPlatformBundle:Model')->findBy(array('make' => $make));
            $form->add('model', EntityType::class, array(
                        'choices' => $models,
                        'class' => Model::class,
                        'label' => 'name',
                        'placeholder' => 'Choose a Model'
                            )
                    )
                    ->add('make', EntityType::class, array(
                        'class' => Make::class,
                        'label' => 'name',
                        //NECESSARY TO AVOID ERROR OF ACCESS TO 'MAKE' CLASS 
                        'mapped' => false,
                        //MAKE PREVISOUSLY OBTAINED FROM MAKE_ID IS LOADED IN MAKE FIELD                         
                        'data' => $make
                            )
            );
        }



        $form->handleRequest($request);
        $antispam = $this->container->get('TautofPlatform.antispam');

        if ($form->isSubmitted() && $form->isValid()) {


            $advert = $form->getData();
            if ($antispam->isSpam($advert->getTitle())) {
                throw new \Exception('Title is too short and has been assimilated as a spam');
            }
            $em = $this->getDoctrine()->getManager();

            $file1 = $advert->getPhoto1();
            $file1Name = md5(uniqid()) . '.' . $file1->guessExtension();
            $file1->move($this->getParameter('images_directory'), $file1Name);
            $advert->setPhoto1($file1Name);

            $file2 = $advert->getPhoto2();
            $file2Name = md5(uniqid()) . '.' . $file2->guessExtension();
            $file2->move($this->getParameter('images_directory'), $file2Name);
            $advert->setPhoto2($file2Name);

            $file3 = $advert->getPhoto3();
            $file3Name = md5(uniqid()) . '.' . $file3->guessExtension();
            $file3->move($this->getParameter('images_directory'), $file3Name);
            $advert->setPhoto1($file3Name);

            $advert->setUser($this->getUser());


            $em->persist($advert);
            $em->flush();
            $isPublished = true;
        } else {
            return $this->render('TautofPlatformBundle:Advert:new.html.twig', array('advertForm' => $form->createView()));
        }
        return $this->render('TautofPlatformBundle:Advert:add.html.twig', array('isPublished' => $isPublished));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @param type $make_id
     * @return type
     */
    public function homeAction($make_id, $isEdited) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TautofPlatformBundle:Make');
        $allMakes = $repo->findAll();
        $allColors = $em->getRepository('TautofPlatformBundle:Color')->findAll();

        # MODEL AND/OR MAKE #

        if ($make_id == -1) {

            # ONLY MAKE #

            return $this->render('TautofPlatformBundle:Advert:homepage.html.twig', array('allMakes' => $allMakes, 'models' => NULL, 'colors' => $allColors, 'current_make_id' => $make_id, 'isEdited' => $isEdited));
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
            return $this->render('TautofPlatformBundle:Advert:homepage.html.twig', array('allMakes' => $allMakes, 'models' => $models, 'current_make_id' => $make_id, 'colors' => $allColors, 'isEdited' => $isEdited));
        }
    }

    public function testAction($id) {

        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('TautofPlatformBundle:Advert');

        $adverts = $repository->getAdvertByMake($id);

        return $this->render('TautofPlatformBundle:Advert:index.html.twig', array('Advert' => $adverts));
    }

    public function sendMailAction() {

        $message = \Swift_Message::newInstance()
                ->setSubject('Advert published')
                ->setFrom('vladxill@gmail.com')
                ->setTo('vanel.remi@gmail.com')
                ->setBody('Your advert has been successfully published');

        $this->get('mailer')->send($message);

        return $this->redirectToRoute('tautof_platform_homepage');
    }

    public function editAdvertAction(Request $req, $advert_id) {



        $advert = new Advert();
        $form = $this->createForm(EditAdvertFormType::class, $advert);
        $form->handleRequest($req);



        if ($form->isSubmitted() && $form->isValid()) {

            /* A VALID FORMULAR HAS BEEN RECEIVED AND IS NOW HANDLED */
            $repository = $this->getDoctrine()->getManager()->getRepository('TautofPlatformBundle:Advert');

            $modAdvert = $form->getData();
            $repository->editAdvert($advert_id, $modAdvert);
            $isEdited = true;
            return $this->redirectToRoute('tautof_platform_homepage', array('isEdited' => $isEdited));
        } else {

            /* NO FILLED FORMULAR RECEIVED --- NEW ADVERT EDIT */

            /* GET ADVERT FROM DATABASE */

            $user = $this->getUser();
            $repoAdvert = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('TautofPlatformBundle:Advert');
            $advert_to_edit = $repoAdvert->find($advert_id);

            /* SET UP FORM */


            $form = $this->createForm(EditAdvertFormType::class, $advert_to_edit);

            $allMakes = $this->getDoctrine()->getManager()->getRepository('TautofPlatformBundle:Make')->findAll();
            $allModels = $this->getDoctrine()->getManager()->getRepository('TautofPlatformBundle:Model')->findAll();
            $allColors = $this->getDoctrine()->getManager()->getRepository('TautofPlatformBundle:Color')->findAll();





            return $this->render('TautofPlatformBundle:Advert:edit.html.twig', array(
                        'editForm' => $form->createView(),
                        'allModels' => $allModels,
                        'allMakes' => $allMakes,
                        'allColors' => $allColors,
                            )
            );
        }
    }

    public function deleteAction($advert_id) {

        $repository = $this->getDoctrine()->getManager()->getRepository('TautofPlatformBundle:Advert');
        $advert = $repository->find($advert_id);
        $this->getDoctrine()->getManager()->remove($advert);
        $this->getDoctrine()->getManager()->flush();

        $allAdverts = $repository->findAll();
        $isDeleted = true;

        return $this->redirectToRoute('tautof_platform_homepage', array('isDeleted' => $isDeleted));
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tautof\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Tautof\PlatformBundle\Form\MakeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class AdvertFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

//        $modelRepo = $options['em']->getRepository('TautofPlatformBundle:Model');
//        
//        $formModifier = function (FormInterface $form, $make) use($modelRepo) {
//
//            if ($make === null) {
//                $models = array();
//            } else {
//                $models = $modelRepo->findBy(array('make' => $make));
//            }
//
//
//            $form->add('model', EntityType::class, array(
//                'class' => 'TautofPlatformBundle:Model',
//                'placeholder' => '',
//                'choices' => $models
//            ));
//        };

        $builder->add('title', TextType::class, array('label' => 'Advert full title'))
                ->add('description', TextType::class)
                ->add('price')
                ->add('color')
                ->add('km')
                ->add('photo1', FileType::class, array('label' => '1st image'))
                ->add('photo2', FileType::class, array('label' => '2nd image'))
                ->add('photo3', FileType::class, array('label' => '3rd image'))
             //   ->add('model')
                ->add('make', EntityType::class, array(
// query choices from this entity
                    'class' => 'TautofPlatformBundle:Make',
                    'mapped' => false,
                    'choice_label' => 'name',
                    'placeholder' => 'Choose a make'
                ))
        ;

//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier) {
//
//            $make = $event->getForm()->get('make')->getData();
//
//            $formModifier($event->getForm(), $make);
//        }
//        );
//        //
//        $builder->get('make')->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($formModifier) {
//
//
//            // It's important here to fetch $event->getForm()->getData(), as
//            // $event->getData() will get you the client data (that is, the ID)
//            $make = $event->getForm()->getData();
//
//            // since we've added the listener to the child, we'll have to pass on
//            // the parent to the callback functions!
//            $formModifier($event->getForm()->getParent(), $make);
//        }
//        );
    }

    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(array(
            'data_class' => 'Tautof\PlatformBundle\Entity\Advert',
            'em' => null
        ));
    }

}

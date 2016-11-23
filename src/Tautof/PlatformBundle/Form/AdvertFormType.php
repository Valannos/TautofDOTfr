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

class AdvertFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('title')
                ->add('description')
                ->add('price')
                ->add('color')
                //->add('user')
                ->add('km')
                ->add('photo1')
                ->add('photo2')
                ->add('photo3')
//                ->add('model')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(['data_class' => 'Tautof\PlatformBundle\Entity\Advert'
        ]);
    }

}

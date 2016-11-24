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

class AdvertFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('title', TextType::class)
                ->add('description', TextType::class)
                ->add('price')
                ->add('color')
                ->add('km')
                ->add('photo1')
                ->add('photo2')
                ->add('photo3')
               // ->add('make')
                ->add('model')
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults(['data_class' => 'Tautof\PlatformBundle\Entity\Advert'
        ]);
    }

}

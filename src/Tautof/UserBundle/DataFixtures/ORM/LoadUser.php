<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tautof\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Tautof\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUser implements FixtureInterface, ContainerAwareInterface {

    /**
     * 
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        // Les noms d'utilisateurs à créer
        $listNames = array('Alexandre', 'Marine', 'Anna');

        foreach ($listNames as $name) {
            // On crée l'utilisateur
            $user = new User;

            // Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
            $user->setPlainPassword($name);
            $user->setName('none');
            $user->setFirstName($name);
            $user->setUsername($name);
            $password = $this->container->get('security.password_encoder')
                    ->encodePassword($user, $user->getPlainPassword());




            // On définit uniquement le role ROLE_USER qui est le role de base
            $user->setRoles(array('ROLE_USER'));
            $user->setPassword($password);





            // On le persiste
            $manager->persist($user);
        }

        // On déclenche l'enregistrement
        $manager->flush();

        $user = new User;

        // Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
        $user->setName('none');
        $user->setPlainPassword('admin');
        $user->setFirstName('none');
        $user->setUsername('root');
        $password = $this->container->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);




        // On définit uniquement le role ROLE_USER qui est le role de base
        $user->setRoles(array('ROLE_ADMIN'));

        // On le persiste
        $manager->persist($user);


        // On déclenche l'enregistrement
        $manager->flush();
    }

}

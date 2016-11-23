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

class LoadUser implements FixtureInterface {

    public function load(ObjectManager $manager) {
        // Les noms d'utilisateurs à créer
        $listNames = array('Alexandre', 'Marine', 'Anna');

        foreach ($listNames as $name) {
            // On crée l'utilisateur
            $user = new User;

            // Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
            $user->setName('none');
            $user->setFirstName($name);
            $user->setUsername($name);
            $user->setPassword($name);

            // On ne se sert pas du sel pour l'instant
            $user->setSalt('');
            // On définit uniquement le role ROLE_USER qui est le role de base
            $user->setRoles(array('ROLE_USER'));
            
            
            
            

            // On le persiste
            $manager->persist($user);
        }

        // On déclenche l'enregistrement
        $manager->flush();
        
         $user = new User;

        // Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
        $user->setName('none');
        $user->setFirstName('none');
        $user->setUsername('root');
        $user->setPassword('admin');

        // On ne se sert pas du sel pour l'instant
        $user->setSalt('');
        // On définit uniquement le role ROLE_USER qui est le role de base
        $user->setRoles(array('ROLE_ADMIN'));

        // On le persiste
        $manager->persist($user);


        // On déclenche l'enregistrement
        $manager->flush();
    }

    public function loadAdmin(ObjectManager $manager) {
        // Les noms d'utilisateurs à créer


        $user = new User;

        // Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
        $user->setName('none');
        $user->setFirstName('none');
        $user->setUsername('root');
        $user->setPassword('admin');

        // On ne se sert pas du sel pour l'instant
        $user->setSalt('');
        // On définit uniquement le role ROLE_USER qui est le role de base
        $user->setRoles(array('ROLE_ADMIN'));

        // On le persiste
        $manager->persist($user);


        // On déclenche l'enregistrement
        $manager->flush();
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tautof\UserBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository {

    public function deleteUserById($id) {


        $user = $this->find($id);
        $em = $this->getEntityManager();
        $em->remove($user);
        $em->flush();
    }

}

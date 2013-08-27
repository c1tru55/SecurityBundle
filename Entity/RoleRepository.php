<?php

namespace ITE\SecurityBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 * @package ITE\SecurityBundle\Entity
 */
class RoleRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAllIndexedByName()
    {
        return $this->getEntityManager()->createQuery('
            SELECT r
            FROM ITESecurityBundle:Role r INDEX BY r.name
        ')
            ->getResult();
    }

    /**
     * @return array
     */
    public function findAllIndexedById()
    {
        return $this->getEntityManager()->createQuery('
            SELECT r
            FROM ITESecurityBundle:Role r INDEX BY r.id
            ORDER BY r.id ASC
        ')
            ->getResult();
    }
}
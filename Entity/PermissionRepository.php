<?php

namespace ITE\SecurityBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class PermissionRepository
 * @package ITE\SecurityBundle\Entity
 */
class PermissionRepository extends EntityRepository
{
    /**
     * @param array $roles
     * @return array
     */
    public function findPermissionsByRoles(array $roles)
    {
        $permissions = $this->getEntityManager()->createQuery('
            SELECT p.name AS permission
            FROM ITESecurityBundle:Role r
            INNER JOIN r.permissions p
            WHERE r.name IN (:roles)
        ')
            ->setParameters(array(
                'roles' => $roles,
            ))
            ->getResult();

        return array_map(function($value) {
            return $value['permission'];
        }, $permissions);
    }

    /**
     * @return array
     */
    public function findAllIndexedById()
    {
        return $this->getEntityManager()->createQuery('
            SELECT p
            FROM ITESecurityBundle:Permission p INDEX BY p.id
            ORDER BY p.id ASC
        ')
            ->getResult();
    }
}
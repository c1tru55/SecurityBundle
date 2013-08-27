<?php

namespace ITE\SecurityBundle\Service;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class PermissionManager implements PermissionManagerInterface
{
    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param SecurityContextInterface $securityContext
     * @param EntityManager $em
     */
    public function __construct(SecurityContextInterface $securityContext, EntityManager $em)
    {
        $this->securityContext = $securityContext;
        $this->em = $em;
    }

    /**
     * @param array $permissions
     * @return bool
     */
    public function hasPermissions(array $permissions)
    {
        /** @var $user UserInterface */
        $user = $this->securityContext->getUser();
        $userRoles = $user->getRoles();

        $userPermissions = $this->em->getRepository('ITESecurityBundle:Permission')
            ->findPermissionsByRoles($userRoles);

        return count(array_intersect($permissions, $userPermissions)) === count($permissions);
    }
}
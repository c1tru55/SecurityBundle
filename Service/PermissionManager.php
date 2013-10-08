<?php

namespace ITE\SecurityBundle\Service;

use FOS\UserBundle\Model\UserInterface;
use ITE\SecurityBundle\Core\SecurityContextInterface;

/**
 * Class PermissionManager
 * @package ITE\SecurityBundle\Service
 */
class PermissionManager implements PermissionManagerInterface
{
    /**
     * @var RolePermissionMapperInterface
     */
    protected $rolePermissionMapper;

    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @param RolePermissionMapperInterface $rolePermissionMapper
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(RolePermissionMapperInterface $rolePermissionMapper, SecurityContextInterface $securityContext)
    {
        $this->rolePermissionMapper = $rolePermissionMapper;
        $this->securityContext = $securityContext;
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

        $userPermissions = $this->rolePermissionMapper->getPermissionsByRoles($userRoles);

        return count(array_intersect($permissions, $userPermissions)) === count($permissions);
    }

}
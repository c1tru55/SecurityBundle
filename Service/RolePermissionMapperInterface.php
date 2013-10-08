<?php

namespace ITE\SecurityBundle\Service;

/**
 * Class RolePermissionMapperInterface
 * @package ITE\SecurityBundle\Service
 */
interface RolePermissionMapperInterface
{
    /**
     * @return array
     */
    public function getRolePermissionMap();

    /**
     *
     */
    public function updateRolePermissionMap();

    /**
     * @param array $roles
     * @return array
     */
    public function getPermissionsByRoles(array $roles);
}
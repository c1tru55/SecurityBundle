<?php

namespace ITE\SecurityBundle\Service;

/**
 * Class PermissionManagerInterface
 * @package ITE\SecurityBundle\Service
 */
interface PermissionManagerInterface
{
    /**
     * @param array $permissions
     * @return bool
     */
    public function hasPermissions(array $permissions);
}
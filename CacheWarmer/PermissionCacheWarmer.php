<?php

namespace ITE\SecurityBundle\CacheWarmer;

use ITE\SecurityBundle\Service\RolePermissionMapperInterface;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmer;

/**
 * Class PermissionCacheWarmer
 * @package ITE\SecurityBundle\CacheWarmer
 */
class PermissionCacheWarmer extends CacheWarmer
{
    /**
     * @var RolePermissionMapperInterface
     */
    protected $rolePermissionMapper;

    /**
     * @param RolePermissionMapperInterface $rolePermissionMapper
     */
    public function __construct(RolePermissionMapperInterface $rolePermissionMapper)
    {
        $this->rolePermissionMapper = $rolePermissionMapper;
    }
    
    /**
     * @param $cacheDir
     */
    public function warmUp($cacheDir)
    {
        $this->rolePermissionMapper->updateRolePermissionMap();
    }

    /**
     * @return bool
     */
    public function isOptional()
    {
        return false;
    }
}
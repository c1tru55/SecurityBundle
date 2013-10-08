<?php

namespace ITE\SecurityBundle\Service;

use Doctrine\ORM\EntityManager;
use ITE\SecurityBundle\Entity\Permission;
use ITE\SecurityBundle\Entity\Role;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class RolePermissionMapper
 * @package ITE\SecurityBundle\Service
 */
class RolePermissionMapper implements RolePermissionMapperInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var array|null
     */
    protected $rolePermissionMap;

    /**
     * @var string
     */
    protected $cacheDir;

    /**
     * @param EntityManager $em
     * @param $cacheDir
     */
    public function __construct(EntityManager $em, $cacheDir)
    {
        $this->em = $em;
        $this->cacheDir = $cacheDir;
    }

    /**
     * @return array
     */
    public function getRolePermissionMap()
    {
        if (!isset($this->rolePermissionMap)) {
            $cacheFilePath = $this->getRolePermissionMapFilePath();

            if (!is_file($cacheFilePath)) {
                $this->updateRolePermissionMap();
            } else {
                $this->rolePermissionMap = require $cacheFilePath;
            }
        }

        return $this->rolePermissionMap;
    }

    /**
     *
     */
    public function updateRolePermissionMap()
    {
        $this->buildRolePermissionMap();
        $this->saveRolePermissionMap();
    }

    /**
     * @param array $roles
     * @return array
     */
    public function getPermissionsByRoles(array $roles)
    {
        $permissions = array();
        foreach ($this->getRolePermissionMap() as $role => $rolePermissions) {
            if (!in_array($role, $roles)) {
                continue;
            }
            $permissions = array_merge($permissions, $rolePermissions);
        }

        return array_unique($permissions);
    }

    /**
     * @return string
     */
    protected function getRolePermissionMapFilePath()
    {
        return $this->cacheDir . DIRECTORY_SEPARATOR . 'rolePermission.map';
    }

    /**
     *
     */
    protected function buildRolePermissionMap()
    {
        $roles = $this->em->getRepository('ITESecurityBundle:Role')->findAllJoinedWithPermissionsIndexedByName();

        $rolePermissionMap = array();
        foreach ($roles as $roleName => $role) {
            $rolePermissionMap[$roleName] = array();
            /** @var $role Role */
            foreach ($role->getPermissions() as $permission) {
                /** @var $permission Permission */
                $rolePermissionMap[$roleName][] = $permission->getName();
            }
        }

        $this->rolePermissionMap = $rolePermissionMap;
    }

    /**
     *
     */
    protected function saveRolePermissionMap()
    {
        $cacheFilePath = $this->getRolePermissionMapFilePath();

        $fs = new Filesystem();
        $fs->dumpFile($cacheFilePath, sprintf('<?php return %s;', var_export($this->rolePermissionMap, true)));
    }
}
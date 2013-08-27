<?php

namespace ITE\SecurityBundle\Annotation;
use InvalidArgumentException;

/**
 * @Annotation
 * @Target("METHOD")
 */
class Permission
{
    protected $permissions = array();

    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $values['permissions'] = $values['value'];
        }
        if (!isset($values['permissions'])) {
            throw new InvalidArgumentException('You must define a "permissions" attribute for each Permission annotation.');
        }

        $permissions = is_array($values['permissions']) ? $values['permissions'] : array_map('trim', explode(',', $values['permissions']));
        $this->permissions = array_unique($permissions);
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

}
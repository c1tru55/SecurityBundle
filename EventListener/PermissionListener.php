<?php

namespace ITE\SecurityBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use ITE\SecurityBundle\Annotation\Permission;
use ITE\SecurityBundle\Service\PermissionManagerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class PermissionListener
 * @package ITE\SecurityBundle\EventListener
 */
class PermissionListener
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var PermissionManagerInterface
     */
    protected $permissionManager;

    /**
     * @param Reader $reader
     * @param PermissionManagerInterface $permissionManager
     */
    public function __construct(Reader $reader, PermissionManagerInterface $permissionManager)
    {
        $this->reader = $reader;
        $this->permissionManager = $permissionManager;
    }

    /**
     * @param FilterControllerEvent $event
     * @throws AccessDeniedHttpException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if (!is_array($controller = $event->getController())) {
            return;
        }

        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);

        foreach ($this->reader->getMethodAnnotations($method) as $annotation) {
            if (!$annotation instanceof Permission) {
                continue;
            }

            if (!$this->permissionManager->hasPermissions($annotation->getPermissions())) {
                throw new AccessDeniedHttpException();
            }
        }
    }
}
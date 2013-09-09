<?php

namespace ITE\SecurityBundle\Core;

use Symfony\Component\Security\Core\SecurityContextInterface as BaseSecurityContextInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Class SecurityContextInterface
 * @package ITE\CoreExtensionsBundle\Security
 */
interface SecurityContextInterface extends BaseSecurityContextInterface
{
    /**
     * @return AdvancedUserInterface
     */
    public function getUser();

    /**
     * @return int|null
     */
    public function getUserId();

    /**
     * @return bool
     */
    public function isAnonymous();

    /**
     * @return bool
     */
    public function isAuthenticated();

    /**
     * @return bool
     */
    public function isFullyAuthenticated();
}
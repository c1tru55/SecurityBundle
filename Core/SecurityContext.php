<?php

namespace ITE\SecurityBundle\Core;

use Symfony\Component\Security\Core\SecurityContext as BaseSecurityContext;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * Class SecurityContext
 * @package ITE\SecurityBundle\Core
 */
class SecurityContext extends BaseSecurityContext implements SecurityContextInterface
{
    /**
     * @return AdvancedUserInterface|null
     */
    public function getUser()
    {
        if ($token = $this->getToken()) {
            if (is_object($user = $token->getUser())) {
                return $user;
            }
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getUserId()
    {
        if ($user = $this->getUser()) {
            return $user->getId();
        }
        return null;
    }

    /**
     * @return bool
     */
    public function isAnonymous()
    {
        return $this->isGranted('IS_AUTHENTICATED_ANONYMOUSLY');
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        return $this->isGranted('IS_AUTHENTICATED_REMEMBERED');
    }

    /**
     * @return bool
     */
    public function isFullyAuthenticated()
    {
        return $this->isGranted('IS_AUTHENTICATED_FULLY');
    }
}
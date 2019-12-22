<?php


namespace Chap\Models;

use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\IIdentity;
use Nette\Security\AuthenticationException;

/**
 * Description of BaseAuthenticator
 *
 * @author chap
 */
class BaseAuthenticator implements IAuthenticator
{
    /**
     * Performs an authentication.
     * @param array $credentials
     * @return IIdentity
     * @throws AuthenticationException
     */
    public function authenticate(array $credentials): IIdentity
    {
        list($username, $password) = $credentials;
        return new Identity(1,null, ['name' => $username]);
    }
}

<?php declare(strict_types=1);

namespace Chap\Base;

use Nette\Security\Permission;

class AclFactory
{
    /**
     * @return Permission
     */
    public static function create(): Permission
    {
        $acl = new Permission();

        $acl->addRole('admin');

        $acl->addResource('Orders');

        $acl->allow('admin', Permission::ALL, Permission::ALL);

        return $acl;

    }

}

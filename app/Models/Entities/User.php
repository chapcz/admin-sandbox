<?php declare(strict_types=1);

namespace Chap\Models\Entities;

use Doctrine\ORM\Mapping as ORM;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;

/**
 * @property integer   $id
 * @property string    $name
 * @property string    $password
 * @property string    $realName
 * @property string    $role
 * @property \DateTime $lastSeen
 * @property \DateTime $birthday
 * @property boolean   $active
 * @property boolean   $deleted
 * @property string    $email
 * @property string    $postcode
 * @property string    $someThing
 *
 * @ORM\Entity()
 * @ORM\Table(name="`user`")
 */
class User extends BaseEntity implements IIdentity
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MANAGER = 'manager';

    public static $ALL_ROLES = [
        'admin'    => 'Administrator',
        'manager'  => 'Manager',
    ];

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="`name`", type="string", length=45)
     */
    protected $name;


    /**
     * @ORM\Column(name="`password`", type="string", length=65)
     */
    protected $password;

    /**
     * set hashed password
     * @param $password
     * @return $this
     */
    public function setPassword($password): self
    {
        if (\strlen($password) > 0) {
            $this->password = Passwords::hash($password);
        }

        return $this;
    }

    /**
     * @ORM\Column(name="realName", type="string", length=45)
     */
    protected $realName;

    /**
     * @ORM\Column(name="`role`", type="string", length=10)
     */
    protected $role;

    /**
     * @ORM\Column(name="last_seen", type="datetime", nullable=true)
     */
    protected $lastSeen;

    /**
     * @ORM\Column(name="active", type="boolean")
     */
    protected $active;

    /**
     * @ORM\Column(name="email", type="string", length=150, nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(name="phone", type="string", nullable=true, length=20)
     */
    protected $phone;

    /**
     * @ORM\Column(name="deleted", type="boolean")
     */
    protected $deleted = false;

    public function setBirthday($start)
    {
        if ($start === null) {
            $this->birthday = null;
        } else {
            $this->birthday = \DateTime::createFromFormat('d.m.Y', $start)->setTime(0, 0);
        }
        return $this;

    }

    public function __construct()
    {
    }

    /**
     * Returns the ID of user.
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a list of roles that the user is a member of.
     * @return array
     */
    public function getRoles(): array
    {
        return [$this->role];
    }


}
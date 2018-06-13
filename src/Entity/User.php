<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Ldap\Entry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=36)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $dn;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    private $roles;

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDn(): string
    {
        return $this->dn;
    }

    public function setDn(string $dn): void
    {
        $this->dn = $dn;
    }

    public function getRoles(): array
    {
        return $this->roles ? : [];
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    public static function fromLdap(Entry $entry): User
    {
        $user = new self();

        $user->setDn($entry->getDn());
        $user->setUsername($entry->getAttribute('sn')[0]);
        $user->setName($entry->getAttribute('cn')[0]);

        return $user;
    }
}

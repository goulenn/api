<?php

namespace App\Entity;

use App\Entity\Common\Id;
use App\Entity\User\LdapUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
{
    use Id;
    use LdapUser;

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
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    private $roles;

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

    public function getRoles(): array
    {
        return $this->roles ? : [];
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
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
}

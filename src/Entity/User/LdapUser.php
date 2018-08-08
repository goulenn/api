<?php

namespace App\Entity\User;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Ldap\Entry;

trait LdapUser
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Exclude
     */
    private $dn;

    public function getDn(): string
    {
        return $this->dn;
    }

    public function setDn(string $dn): void
    {
        $this->dn = $dn;
    }

    public static function fromLdap(Entry $entry): User
    {
        $user = new User();

        $user->setDn($entry->getDn());
        $user->setUsername($entry->getAttribute('sn')[0]);
        $user->setName($entry->getAttribute('cn')[0]);
        $user->setRoles(['ROLE_USER']);

        return $user;
    }
}

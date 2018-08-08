<?php

namespace App\Security\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class LdapUserProvider implements UserProviderInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return UserRepository
     */
    public function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }

    /**
     * @param UserRepository $userRepository
     */
    public function setUserRepository(UserRepository $userRepository): void
    {
        $this->userRepository = $userRepository;
    }

    public function loadUserByUsername($username): User
    {
        $user = $this->userRepository->findOneByUsername($username);

        if (!$username) {
            throw new UsernameNotFoundException();
        }

        return $user;
    }

    public function loadUserFromLdap($username): User
    {
        $ldap = Ldap::create('ext_ldap', [
            'connection_string' => 'ldap://localhost:10389'
        ]);

        $ldap->bind('uid=admin,ou=system', 'secret');
        $result = $ldap->query('dc=example,dc=com', sprintf('sn=%s', $username))->execute()->toArray();

        if (!$result) {
            throw new UsernameNotFoundException();
        }

        return User::fromLdap($result[0]);
    }

    public function refreshUser(UserInterface $user): User
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of %s are not supported', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class): bool
    {
        return User::class === $class;
    }
}

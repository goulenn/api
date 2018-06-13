<?php

namespace App\Security;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class LdapAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var AuthenticationSuccessHandler
     */
    private $successHandler;

    public function __construct(AuthenticationSuccessHandler $successHandler)
    {
        $this->successHandler = $successHandler;
    }


    public function supports(Request $request): bool
    {
        return $request->request->has('_username') && $request->request->has('_password');
    }

    public function getCredentials(Request $request): array
    {
        return [
            'username' => $request->request->get('_username'),
            'password' => $request->request->get('_password')
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider): UserInterface
    {
        return $userProvider->loadUserByUsername($credentials['username']);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        /** @var User $user */
        $ldap = Ldap::create('ext_ldap', [
            'connection_string' => 'ldap://localhost:10389'
        ]);

        try {
            $ldap->bind($user->getDn(), $credentials['password']);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): Response
    {
        return $this->successHandler->onAuthenticationSuccess($request, $token);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    public function start(Request $request, AuthenticationException $authException = null): JsonResponse
    {
        $data = [
            'message' => 'Authentication required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe(): bool
    {
        return false;
    }
}

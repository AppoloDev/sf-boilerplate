<?php

namespace App\Core\Security;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use League\OAuth2\Client\Provider\GoogleUser;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class GoogleAuthenticator extends OAuth2Authenticator implements AuthenticationEntrypointInterface
{
    public function __construct(
        protected readonly ClientRegistry $clientRegistry,
        protected readonly EntityManagerInterface $entityManager,
        protected readonly UserRepository $userRepository,
        protected readonly RouterInterface $router
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return 'auth_connect_google_check' === $request->attributes->get('_route');
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('google');
        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge($accessToken->getToken(), function () use ($accessToken, $client) {
                /** @var GoogleUser $googleUser */
                $googleUser = $client->fetchUserFromToken($accessToken);

                $user = $this->userRepository->findOneBy(['googleId' => $googleUser->getId()]);

                if ($user instanceof User) {
                    return $user;
                }

                $user = $this->userRepository->findOneBy(['email' => $googleUser->getEmail()]);

                if ($user instanceof User) {
                    $user->setGoogleId($googleUser->getId());
                    $this->entityManager->flush();

                    return $user;
                }

                $user = (new User())
                    ->setGoogleId($googleUser->getId())
                    ->setEmail($googleUser->getEmail())
                    ->setFirstname($googleUser->getFirstName())
                    ->setLastname($googleUser->getLastName())
                ;
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                return $user;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $targetUrl = $this->router->generate('admin_dashboard');

        return new RedirectResponse($targetUrl);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse(
            '/connect/', // might be the site, where users choose their oauth provider
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }
}

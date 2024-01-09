<?php

namespace App\Http\Auth\Voter;

use AppoloDev\SFToolboxBundle\Security\Authorization\AbstractVoter;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class GoogleVoter extends AbstractVoter
{
    public const LOGIN = 'auth_google_login';

    public function __construct(
        Security $security,
        #[Autowire('%env(OAUTH_GOOGLE_CLIENT_ID)%')]
        protected readonly ?string $clientId,
        #[Autowire('%env(OAUTH_GOOGLE_CLIENT_SECRET)%')]
        protected readonly ?string $clientSecret
    ) {
        parent::__construct($security);
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return match ($attribute) {
            self::LOGIN => true,
            default => false,
        };
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        return !is_null($this->clientId)
            && '' !== $this->clientId
            && !is_null($this->clientSecret)
            && '' !== $this->clientSecret;
    }
}

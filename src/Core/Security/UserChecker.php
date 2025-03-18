<?php

namespace App\Core\Security;

use App\Domain\User\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    /**
     * @param User $user
     */
    public function checkPreAuth(UserInterface $user): void
    {
        // TODO: Translation
        if ($user->isBlocked()) {
            throw new CustomUserMessageAccountStatusException('Votre compte a été bloqué. Merci de contacter un administrateur.');
        }

        if ($user->isDeleted()) {
            throw new CustomUserMessageAccountStatusException('Votre compte a été supprimé. Merci de contacter un administrateur.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
    }
}

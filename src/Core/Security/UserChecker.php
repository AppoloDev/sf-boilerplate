<?php

namespace App\Core\Security;

use App\Domain\User\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class UserChecker implements UserCheckerInterface
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    /**
     * @param User $user
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if ($user->isBlocked()) {

            throw new CustomUserMessageAccountStatusException($this->translator->trans('your_account_has_been_blocked'));
        }

        if ($user->isDeleted()) {
            throw new CustomUserMessageAccountStatusException($this->translator->trans('your_account_has_been_deleted'));
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
    }
}

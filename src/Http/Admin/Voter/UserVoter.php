<?php

namespace App\Http\Admin\Voter;

use App\Domain\User\Entity\User;
use AppoloDev\SFToolboxBundle\Domain\Entity\Concern\BlockableInterface;
use AppoloDev\SFToolboxBundle\Security\Authorization\AbstractVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserVoter extends AbstractVoter
{
    public const LIST = 'admin_user_list';
    public const ADD = 'admin_user_add';
    public const EDIT = 'admin_user_edit';
    public const BLOCK = 'admin_user_block';
    public const UNBLOCK = 'admin_user_unblock';
    public const DELETE = 'admin_user_delete';
    public const EXPORT = 'admin_user_export';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return match ($attribute) {
            self::LIST, self::ADD, self::EXPORT => true,
            self::EDIT, self::BLOCK, self::UNBLOCK, self::DELETE => $subject instanceof User,
            default => false,
        };
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        return match ($attribute) {
            self::UNBLOCK => $subject instanceof BlockableInterface && $subject->isBlocked() && $this->canAllowAdmin(),
            self::BLOCK => $subject instanceof BlockableInterface && !$subject->isBlocked() && $this->canAllowAdmin(),
            default => $this->canAllowAdmin(),
        };
    }
}

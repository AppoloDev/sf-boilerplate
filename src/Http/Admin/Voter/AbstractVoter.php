<?php

namespace App\Http\Admin\Voter;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

abstract class AbstractVoter extends Voter
{
    public function __construct(private readonly Security $security)
    {
    }

    protected function canAllowAdmin(): bool
    {
        return $this->canAllow('ROLE_ADMIN');
    }

    protected function canAllow(array|string $roles): bool
    {
        if (!is_array($roles)) {
            return $this->security->isGranted($roles);
        }

        foreach ($roles as $role) {
            if ($this->security->isGranted($role)) {
                return true;
            }
        }

        return false;
    }
}

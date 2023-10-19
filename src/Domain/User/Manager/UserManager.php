<?php

namespace App\Domain\User\Manager;

use App\Domain\User\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class UserManager
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function upgradePassword(User $user): self
    {
        $userHash = $this->passwordHasher->hashPassword($user, $user->getPlainPassword() ?? uniqid());
        $user->setPassword($userHash);

        return $this;
    }

    public function resetConfirmationToken(User $user): self
    {
        $user
            ->setConfirmationToken(null)
            ->setConfirmationTokenExpiredAt(null);

        return $this;
    }

    public function generateConfirmationToken(User $user): self
    {
        $user
            ->setConfirmationToken(str_replace('-', '', (string) Uuid::v4()))
            ->setConfirmationTokenExpiredAt((new \DateTimeImmutable())->add(new \DateInterval(is_null($user->getLastLogin()) ? 'P7D' : 'P1D')));

        return $this;
    }

    public function anonymize(User $user): self
    {
        $user
            ->setEmail(uniqid().'@anonymize.local')
            ->setDeleted(true);

        return $this;
    }
}

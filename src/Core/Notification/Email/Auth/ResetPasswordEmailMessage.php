<?php

namespace App\Core\Notification\Email\Auth;

use App\Domain\User\Entity\User;
use AppoloDev\SFToolboxBundle\Message\EmailMessage;

class ResetPasswordEmailMessage extends EmailMessage
{
    private string $object = 'Réinitialisez votre mot de passe pour votre compte 🔒';

    protected string $template = '_emails/auth/reset_password.html.twig';

    public function __construct(User $user)
    {
        parent::__construct(
            [$user->getEmail()],
            $this->object,
            $this->template,
            [
                'confirmationToken' => $user->getConfirmationToken(),
                'firstname' => $user->getFirstname(),
            ]
        );
    }
}

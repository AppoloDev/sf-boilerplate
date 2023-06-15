<?php

namespace App\Core\Notification\Email\User;

use App\Core\Notification\Message\EmailMessage;
use App\Domain\User\Entity\User;

// TODO : SendEmailMessage
class AccountCreationEmailMessage extends EmailMessage
{
    private string $object = 'Bienvenue 🎉';

    protected string $template = '_emails/user/account_creation.html.twig';

    public function __construct(User $user)
    {
        parent::__construct(
            $user->getEmail(),
            $this->object,
            $this->template,
            [
                'confirmationToken' => $user->getConfirmationToken(),
                'firstname' => $user->getFirstname(),
            ]
        );
    }
}

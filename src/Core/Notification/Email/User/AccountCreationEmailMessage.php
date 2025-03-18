<?php

namespace App\Core\Notification\Email\User;

use App\Domain\User\Entity\User;
use AppoloDev\SFToolboxBundle\Message\EmailMessage;

class AccountCreationEmailMessage extends EmailMessage
{
    // TODO: Translation
    private string $object = 'Bienvenue 🎉';

    protected string $template = '_emails/user/account_creation.html.twig';

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

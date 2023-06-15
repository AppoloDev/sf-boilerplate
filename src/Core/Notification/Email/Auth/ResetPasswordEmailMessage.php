<?php

namespace App\Core\Notification\Email\Auth;

use App\Domain\User\Entity\User;
use AppoloDev\SFToolboxBundle\Message\EmailMessage;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;

class ResetPasswordEmailMessage extends SendEmailMessage
{
    private string $object = 'Réinitialisez votre mot de passe pour votre compte 🔒';

    protected string $template = '_emails/auth/reset_password.html.twig';

    public function __construct(User $user)
    {
        $message = new EmailMessage(
            [$user->getEmail()],
            $this->object,
            $this->template,
            [
                'confirmationToken' => $user->getConfirmationToken(),
                'firstname' => $user->getFirstname(),
            ]
        );

        parent::__construct($message);
    }
}

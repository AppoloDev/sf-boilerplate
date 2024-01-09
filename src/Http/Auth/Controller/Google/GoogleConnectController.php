<?php

namespace App\Http\Auth\Controller\Google;

use AppoloDev\SFToolboxBundle\Security\Http\Attribute\IsNotGranted;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/connect/google', name: 'connect_google')]
#[IsNotGranted('IS_AUTHENTICATED')]
class GoogleConnectController extends AbstractController
{
    public function __invoke(ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect([
                'profile', 'email',
            ], []);
    }
}

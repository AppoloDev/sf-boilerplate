<?php

namespace App\Http\Auth\Controller\Google;

use AppoloDev\SFToolboxBundle\Security\Http\Attribute\IsNotGranted;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/connect/google/check', name: 'connect_google_check')]
#[IsNotGranted('IS_AUTHENTICATED')]
class GoogleCheckController extends AbstractController
{
    public function __invoke(Request $request, ClientRegistry $clientRegistry): Response
    {
        return new Response('');
    }
}

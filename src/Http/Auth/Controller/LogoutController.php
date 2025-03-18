<?php

namespace App\Http\Auth\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: [
    'en' => '/logout',
    'es' => '/cerrar-sesion',
    'fr' => '/deconnexion'
], name: 'logout')]
class LogoutController extends AbstractController
{
    public function __invoke(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

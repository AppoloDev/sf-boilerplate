<?php

namespace App\Http\Auth\Controller;

use App\Domain\User\Repository\UserRepository;
use App\Http\Auth\Form\LoginType;
use AppoloDev\SFToolboxBundle\Security\Http\Attribute\IsNotGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '/', name: 'login')]
#[IsNotGranted('IS_AUTHENTICATED')]
class LoginController extends AbstractController
{
    public function __invoke(
        Request $request,
        AuthenticationUtils $authenticationUtils,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(LoginType::class, null);
        $form->handleRequest($request);

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('areas/auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'form' => $form,
        ]);
    }
}

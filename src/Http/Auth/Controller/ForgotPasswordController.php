<?php

namespace App\Http\Auth\Controller;

use App\Core\Notification\Email\Auth\ResetPasswordEmailMessage;
use App\Domain\User\Manager\UserManager;
use App\Domain\User\Repository\UserRepository;
use App\Http\Auth\Form\ForgotPasswordType;
use AppoloDev\SFToolboxBundle\Security\Http\Attribute\IsNotGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: [
    'en' => '/forgot-password',
    'es' => '/contrasena-olvidada',
    'fr' => '/mot-de-passe-oublie'
], name: 'forgot_password')]
#[IsNotGranted('IS_AUTHENTICATED')]
class ForgotPasswordController extends AbstractController
{
    /**
     * @throws ExceptionInterface
     */
    public function __invoke(
        Request $request,
        UserRepository $userRepository,
        UserManager $userManager,
        MessageBusInterface $messageBus,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = is_string($form->get('email')->getData()) ? $form->get('email')->getData() : '';

            $user = $userRepository->findOneBy(['email' => $email]);

            if (!is_null($user)) {
                $userManager->generateConfirmationToken($user);
                $entityManager->flush();
                $messageBus->dispatch(new ResetPasswordEmailMessage($user));

                return $this->render('areas/auth/forgot_password.html.twig', [
                    'form' => null,
                ]);
            }

            return $this->render('areas/auth/forgot_password.html.twig', [
                'form' => $form,
                'error' => 'invalid_email',
            ]);
        }

        return $this->render('areas/auth/forgot_password.html.twig', [
            'form' => $form,
        ]);
    }
}

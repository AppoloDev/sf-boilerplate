<?php

namespace App\Http\Auth\Controller;

use App\Domain\User\Manager\UserManager;
use App\Domain\User\Repository\UserRepository;
use App\Http\Auth\Form\CreatePasswordType;
use AppoloDev\SFToolboxBundle\Security\Http\Attribute\IsNotGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/creation-de-mot-de-passe/{token}', name: 'create_password')]
#[IsNotGranted('IS_AUTHENTICATED')]
class CreatePasswordController extends AbstractController
{
    public function __invoke(
        string $token,
        Request $request,
        UserRepository $userRepository,
        UserManager $userManager,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $userRepository->findOneBy(['confirmationToken' => $token]);

        if (is_null($user)) {
            return $this->render('areas/auth/create_password.html.twig', [
                'user' => $user,
                'error' => 'invalid_link',
                'form' => null,
            ]);
        }

        if ($user->getConfirmationTokenExpiredAt() <= new \DateTimeImmutable()) {
            return $this->render('areas/auth/create_password.html.twig', [
                'user' => $user,
                'error' => 'expired_link',
                'form' => null,
            ]);
        }

        $form = $this->createForm(CreatePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager
                ->upgradePassword($user)
                ->resetConfirmationToken($user)
            ;
            $entityManager->flush();

            return $this->render('areas/auth/create_password.html.twig', [
                'user' => $user,
                'form' => null,
            ]);
        }

        return $this->render('areas/auth/create_password.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}

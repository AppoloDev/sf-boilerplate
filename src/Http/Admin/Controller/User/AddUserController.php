<?php

namespace App\Http\Admin\Controller\User;

use App\Core\Notification\Email\User\AccountCreationEmailMessage;
use App\Domain\User\Entity\User;
use App\Domain\User\Manager\UserManager;
use App\Http\Admin\Form\User\UserFormType;
use App\Http\Admin\Voter\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: 'utilisateur/ajouter', name: 'user_add')]
class AddUserController extends AbstractController
{
    public function __invoke(
        Request $request,
        EntityManagerInterface $entityManager,
        UserManager $userManager,
        MessageBusInterface $messageBus
    ): Response {
        $this->denyAccessUnlessGranted(UserVoter::ADD);

        $user = (new User());

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->generateConfirmationToken($user);
            $entityManager->persist($user);
            $entityManager->flush();

            $messageBus->dispatch(new AccountCreationEmailMessage($user));

            $this->addFlash('success', 'L\'utilisateur a été ajouté.');

            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('areas/admin/user/add.html.twig', [
            'form' => $form,
        ]);
    }
}

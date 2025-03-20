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
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(path: [
    'en' => '/user/add',
    'es' => '/usuario/agregar',
    'fr' => '/utilisateur/ajouter'
], name: 'user_add')]
#[IsGranted(UserVoter::ADD)]
class AddUserController extends AbstractController
{
    /**
     * @throws ExceptionInterface
     */
    public function __invoke(
        Request $request,
        EntityManagerInterface $entityManager,
        UserManager $userManager,
        MessageBusInterface $messageBus,
        TranslatorInterface $translator
    ): Response {
        $user = (new User());

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->generateConfirmationToken($user);
            $entityManager->persist($user);
            $entityManager->flush();

            $messageBus->dispatch(new AccountCreationEmailMessage($user));

            $this->addFlash('success', $translator->trans('the_item_has_been_saved'));

            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('areas/admin/user/add.html.twig', [
            'form' => $form,
        ]);
    }
}

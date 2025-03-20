<?php

namespace App\Http\Admin\Controller\Account;

use App\Domain\User\Entity\User;
use App\Domain\User\Manager\UserManager;
use App\Http\Admin\Form\User\AccountFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(path: [
    'en' => '/my-account',
    'es' => '/mi-cuenta',
    'fr' => '/mon-compte'
], name: 'account_edit')]
class EditAccountController extends AbstractController
{
    /**
     * @param User $user
     */
    public function __invoke(
        Request $request,
        EntityManagerInterface $entityManager,
        UserManager $userManager,
        TranslatorInterface $translator,
        #[CurrentUser] UserInterface $user
    ): Response {
        $form = $this->createForm(AccountFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!is_null($user->getPlainPassword()) && '' !== $user->getPlainPassword()) {
                $userManager->upgradePassword($user);
            }

            $this->addFlash('success', $translator->trans('the_item_has_been_updated'));
            $entityManager->flush();
        }

        return $this->render('areas/admin/account/edit.html.twig', [
            'form' => $form,
        ]);
    }
}

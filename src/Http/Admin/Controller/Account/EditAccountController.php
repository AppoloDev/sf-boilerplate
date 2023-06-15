<?php

namespace App\Http\Admin\Controller\Account;

use App\Domain\User\Entity\User;
use App\Domain\User\Manager\UserManager;
use App\Http\Admin\Form\User\AccountFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/mon-compte', name: 'account_edit')]
class EditAccountController extends AbstractController
{
    public function __invoke(
        Request $request,
        EntityManagerInterface $entityManager,
        UserManager $userManager,
    ): Response {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(AccountFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!is_null($user->getPlainPassword()) && '' !== $user->getPlainPassword()) {
                $userManager->upgradePassword($user);
            }

            $this->addFlash('success', 'Les informations ont été enregistrées.');
            $entityManager->flush();
        }

        return $this->render('areas/admin/account/edit.html.twig', [
            'form' => $form,
        ]);
    }
}

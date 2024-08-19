<?php

namespace App\Http\Admin\Controller\User;

use App\Domain\User\Entity\User;
use App\Http\Admin\Form\User\UserFormType;
use App\Http\Admin\Voter\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: 'utilisateur/{id}/modifier', name: 'user_edit')]
#[IsGranted(UserVoter::EDIT, 'user')]
class EditUserController extends AbstractController
{
    public function __invoke(
        User $user,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'L\'utilisateur a été modifié.');

            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('areas/admin/user/edit.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }
}

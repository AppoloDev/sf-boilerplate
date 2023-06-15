<?php

namespace App\Http\Admin\Controller\User;

use App\Domain\User\Entity\User;
use App\Domain\User\Manager\UserManager;
use App\Http\Admin\Voter\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: 'utilisateur/{id}/supprimer', name: 'user_delete')]
#[IsGranted(UserVoter::DELETE, 'user')]
class DeleteUserController extends AbstractController
{
    public function __invoke(User $user, UserManager $userManager, EntityManagerInterface $entityManager): Response
    {
        $userManager->anonymize($user);
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a été supprimé.');

        return $this->redirectToRoute('admin_user_list');
    }
}

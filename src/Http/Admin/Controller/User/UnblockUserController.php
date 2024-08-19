<?php

namespace App\Http\Admin\Controller\User;

use App\Domain\User\Entity\User;
use App\Http\Admin\Voter\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: 'utilisateur/{id}/debloquer', name: 'user_unblock')]
#[IsGranted(UserVoter::UNBLOCK, 'user')]
class UnblockUserController extends AbstractController
{
    public function __invoke(User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setBlocked(false);
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a été débloqué.');

        return $this->redirectToRoute('admin_user_list');
    }
}

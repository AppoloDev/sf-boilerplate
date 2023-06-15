<?php

namespace App\Http\Admin\Controller\User;

use App\Domain\User\Entity\User;
use App\Http\Admin\Voter\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: 'utilisateur/{id}/bloquer', name: 'user_block')]
#[IsGranted(UserVoter::BLOCK, 'user')]
class BlockUserController extends AbstractController
{
    public function __invoke(User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setBlocked(true);
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a été bloqué.');

        return $this->redirectToRoute('admin_user_list');
    }
}

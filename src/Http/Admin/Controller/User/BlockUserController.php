<?php

namespace App\Http\Admin\Controller\User;

use App\Domain\User\Entity\User;
use App\Http\Admin\Voter\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route(path: [
    'en' => '/user/{id}/block',
    'es' => '/usuario/{id}/bloquear',
    'fr' => '/utilisateur/{id}/bloquer'
], name: 'user_block')]
#[IsGranted(UserVoter::BLOCK, 'user')]
class BlockUserController extends AbstractController
{
    public function __invoke(
        User $user,
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator
    ): Response
    {
        $user->setBlocked(true);
        $entityManager->flush();

        $this->addFlash('success', $translator->trans('the_item_has_been_blocked'));

        return $this->redirectToRoute('admin_user_list');
    }
}

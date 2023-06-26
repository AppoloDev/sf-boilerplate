<?php

namespace App\Http\Admin\Controller\User;

use App\Domain\User\Repository\UserRepository;
use App\Http\Admin\Voter\UserVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: 'utilisateurs/exporter', name: 'user_export')]
#[IsGranted(UserVoter::EXPORT)]
class ExportUserController extends AbstractController
{
    public function __invoke(Request $request,UserRepository $userRepository,): Response {
        // TODO: Implement
    }
}

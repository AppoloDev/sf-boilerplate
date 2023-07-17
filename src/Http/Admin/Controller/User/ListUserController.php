<?php

namespace App\Http\Admin\Controller\User;

use App\Domain\User\Repository\UserRepository;
use App\Http\Admin\Voter\UserVoter;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: 'utilisateurs', name: 'user_list')]
#[IsGranted(UserVoter::LIST)]
class ListUserController extends AbstractController
{
    public function __invoke(
        Request $request,
        UserRepository $userRepository,
        PaginatorInterface $paginator,
        #[MapQueryParameter] ?string $q,
    ): Response {
        $pagination = $paginator->paginate(
            $userRepository
                ->getQB()
                ->querySearch($q)
                ->order('updatedAt', 'DESC')
                ->getBuilder(),
            $request->query->getInt('page', 1),
            12,
            [
                'defaultSortFieldName' => 'u.updatedAt',
                'defaultSortDirection' => 'desc',
            ]
        );

        return $this->render('areas/admin/user/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}

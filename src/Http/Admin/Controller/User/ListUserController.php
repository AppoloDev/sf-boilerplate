<?php

namespace App\Http\Admin\Controller\User;

use App\Domain\User\Repository\UserRepository;
use App\Http\Admin\Voter\UserVoter;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: 'utilisateurs', name: 'user_list')]
class ListUserController extends AbstractController
{
    public function __invoke(
        Request $request,
        UserRepository $userRepository,
        PaginatorInterface $paginator,
    ): Response {
        $this->denyAccessUnlessGranted(UserVoter::LIST);

        $pagination = $paginator->paginate(
            $userRepository
                ->getQB()
                ->querySearch((string) $request->query->get('q'))
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
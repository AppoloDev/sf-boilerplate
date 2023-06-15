<?php

namespace App\Http\Admin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route(path: '/', name: 'dashboard')]
    public function __invoke(): Response
    {
        return $this->redirectToRoute('admin_user_list');
    }
}

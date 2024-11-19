<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboardPage(): Response
    {
        return $this->render('shared/dashboard.html.twig');
    }
}

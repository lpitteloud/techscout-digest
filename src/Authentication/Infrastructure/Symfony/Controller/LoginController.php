<?php

declare(strict_types=1);

namespace Authentication\Infrastructure\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function loginPage(): Response
    {
        return $this->render('authentication/login.html.twig');
    }
}

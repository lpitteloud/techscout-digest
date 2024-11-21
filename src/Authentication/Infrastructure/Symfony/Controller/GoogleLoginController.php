<?php

declare(strict_types=1);

namespace Authentication\Infrastructure\Symfony\Controller;

use Authentication\Application\Service\GoogleLoginService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoogleLoginController extends AbstractController
{
    public function __construct(
        private readonly GoogleLoginService $loginService,
    ) {
    }

    #[Route('/login/google', name: 'google_login')]
    public function initiateGoogleLogin(): Response
    {
        return $this->redirect($this->loginService->getRedirectUrl());
    }

    #[Route('/login/google/callback', name: 'google_login_callback')]
    public function handleGoogleCallback(Request $request): Response
    {
        $code = $request->query->get('code', '');
        $user = $this->loginService->handleGoogleCallback($code);

        if ($user) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->redirectToRoute('login');
    }
}

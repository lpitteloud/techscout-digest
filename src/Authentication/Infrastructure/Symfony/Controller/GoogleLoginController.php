<?php

declare(strict_types=1);

namespace Authentication\Infrastructure\Symfony\Controller;

use Authentication\Application\Service\GoogleLoginService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GoogleLoginController extends AbstractController
{
    public function __construct(
        private readonly GoogleLoginService $loginService,
    ) {
    }

    #[Route('/login/google', name: 'google_login', methods: ['GET'])]
    public function initiateGoogleLogin(): RedirectResponse
    {
        return $this->redirect($this->loginService->getRedirectUrl());
    }

    #[Route('/login/google/callback', name: 'google_login_callback', methods: ['GET'])]
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        $code = $request->query->get('code', '');
        $user = $this->loginService->handleGoogleCallback($code);

        if ($user) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->redirectToRoute('login');
    }
}

<?php

// src/Security/AuthenticationEntryPoint.php
namespace App\Security;

use App\Exceptions\InactiveUserException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse
    {
        if ($authException instanceof InactiveUserException) {
            $request->getSession()->getFlashBag()->add('note', 'Your account is not active. Please confirm your email.');
        } else {
            $request->getSession()->getFlashBag()->add('note', 'You have to login in order to access this page.');
        }

        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }

}
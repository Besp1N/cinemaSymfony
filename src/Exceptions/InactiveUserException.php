<?php

namespace App\Exceptions;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

class InactiveUserException extends AccountStatusException
{
    public function getMessageKey(): string
    {
        return 'Your account is not active. Please confirm your email.';
    }
}

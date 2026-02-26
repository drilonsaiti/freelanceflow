<?php

namespace App\Domain\Identity\Exceptions;

final class InvalidCredentialsException extends \RuntimeException
{

    public function __construct()
    {
        parent::__construct('Invalid credentials provided', 401);
    }

}

<?php

namespace App\Domain\Project\Exceptions;

final class InvalidProjectTransitionException extends \Exception
{

    public function __construct()
    {
        parent::__construct('This project cannot transition to the requested status.',400);
    }
}

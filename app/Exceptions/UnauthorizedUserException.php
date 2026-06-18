<?php

declare(strict_types=1);

namespace App\Exceptions;

class UnauthorizedUserException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Não autorizado! Você precisa estar logado para poder acessar o sistema');
    }
}

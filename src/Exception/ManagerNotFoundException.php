<?php 

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ManagerNotFoundException extends NotFoundHttpException
{
    public function __construct(string $message = 'The manager cannot be found.', Throwable $previous = null)
    {
        parent::__construct($message, $previous, Response::HTTP_NOT_FOUND);
    }
}
<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class TemplateNotFoundException
 *
 * @package App\Exception
 */
class TemplateNotFoundException extends \DomainException
{
    /**
     * TemplateNotFoundException constructor.
     *
     * @param string $message
     * @param int    $code
     */
    public function __construct($message = "Template não encontrado!", $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $code, null);
    }

}

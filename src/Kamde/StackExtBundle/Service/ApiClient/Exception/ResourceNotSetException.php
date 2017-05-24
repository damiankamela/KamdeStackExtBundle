<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Exception;

use Throwable;

class ResourceNotSetException extends \Exception
{
    public function __construct(string $lackingParameter, string $message = "", $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = sprintf(
                'You must set "%s" parameter. Try to use "set%s($%1$s)" method.',
                $lackingParameter,
                ucfirst($lackingParameter)
            );
        }

        parent::__construct($message, $code, $previous);
    }
}
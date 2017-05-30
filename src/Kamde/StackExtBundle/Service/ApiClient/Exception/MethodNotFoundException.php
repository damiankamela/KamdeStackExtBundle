<?php

namespace Kamde\StackExtBundle\Service\ApiClient\Exception;

use Throwable;

class MethodNotFoundException extends \Exception
{
    /**
     * MethodNotFoundException constructor.
     * @param string         $method
     * @param string         $class
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $method, string $class, $code = 0, Throwable $previous = null)
    {
        $message = sprintf('Method "%s" not found in "%s" class.', $method, $class);

        parent::__construct($message, $code, $previous);
    }
}
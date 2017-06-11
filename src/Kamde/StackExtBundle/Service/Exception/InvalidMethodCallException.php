<?php

namespace Kamde\StackExtBundle\Service\Exception;

use Throwable;

class InvalidMethodCallException extends \Exception
{
    /**
     * @param string         $method
     * @param string         $class
     * @param array          $arguments
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $method,
        string $class,
        array $arguments = [],
        $code = 0,
        Throwable $previous = null
    ) {
        $message = sprintf(
            'Method "%s(%s)" in "%s" class is invalid or has invalid arguments. Read the resource documentation.',
            $method,
            implode(', ', $arguments),
            $class
        );

        parent::__construct($message, $code, $previous);
    }
}
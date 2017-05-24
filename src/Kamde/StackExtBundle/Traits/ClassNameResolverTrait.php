<?php

namespace Kamde\StackExtBundle\Traits;

trait ClassNameResolverTrait
{
    /**
     * @return string
     */
    protected function getShortClassName(): string
    {
        return substr(strrchr(get_called_class(), "\\"), 1);
    }

    /**
     * @param string $text
     * @param string $separator
     * @return string
     */
    protected function decamelize(string $text, string $separator)
    {
        return strtolower(preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $separator, $text));
    }
}
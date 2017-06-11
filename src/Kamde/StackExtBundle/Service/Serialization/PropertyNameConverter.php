<?php

namespace Kamde\StackExtBundle\Service\Serialization;

use Kamde\StackExtBundle\Traits\ClassNameResolverTrait;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class PropertyNameConverter implements NameConverterInterface
{
    use ClassNameResolverTrait;

    /** @var string */
    protected $serializedClass;

    /**
     * PropertyNameConverter constructor.
     * @param string $serializedClass
     */
    public function __construct(string $serializedClass)
    {
        $this->serializedClass = $serializedClass;
    }

    /**
     * @param string $propertyName
     * @return string
     */
    public function normalize($propertyName)
    {
        return $this->getPropertyPrefix() . $propertyName;
    }

    /**
     * @param string $propertyName
     * @return string
     */
    public function denormalize($propertyName)
    {
        return str_replace($this->getPropertyPrefix(), '', $propertyName);
    }

    /**
     * @return string
     */
    protected function getPropertyPrefix(): string
    {
        $name = $this->getShortClassName($this->serializedClass);

        return $this->decamelize($name, '_') . '_';
    }
}
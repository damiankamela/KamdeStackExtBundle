<?php

namespace Kamde\StackExtBundle\Service\Resource;

use Kamde\StackExtBundle\Service\Serialization\PropertyNameConverter;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ResourceNormalizer
{
    /**
     * @param string $modelClass
     * @param array  $data
     * @return object
     */
    public function normalize(string $modelClass, array $data)
    {
        $serializer = new Serializer([
            new ObjectNormalizer(null, new PropertyNameConverter($modelClass))
        ], [
            new JsonEncoder(),
        ]);

        return $serializer->denormalize($data, $modelClass);
    }
}
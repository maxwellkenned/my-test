<?php

namespace App\Service;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

/**
 * Class SerializerService
 *
 * @package App\Service
 */
class SerializerService
{

    /** @var SerializerInterface */
    private $serializer;

    /**
     * SerializerService constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param        $data
     * @param string $format
     *
     * @return string
     */
    public function toJson($data, string $format = 'json'): ?string
    {
        return $this->serializer->serialize($data, $format);
    }

    /**
     * @param string $jsonData
     * @param string $type
     * @param string $format
     *
     * @return mixed
     */
    public function converter(string $jsonData, string $type, string $format = 'json')
    {
        return $this->serializer->deserialize($jsonData, $type, $format);
    }

    /**
     * @param array  $data
     * @param string $type
     * @param string $format
     *
     * @return mixed
     */
    public function normalizer($data, string $type, string $format = 'json')
    {
        $data = is_string($data) ? json_decode($data, true) : $data;
        $jsonData = $this->toJson($data, $format);

        return $this->converter($jsonData, $type, $format);
    }

    /**
     * @param       $data
     * @param array $groups
     *
     * @return string
     */
    public function toJsonByGroups($data, array $groups = ['default']): ?string
    {
        return $this->serializer->serialize(
            $data,
            'json',
            SerializationContext::create()->setGroups($groups)
        );
    }
}

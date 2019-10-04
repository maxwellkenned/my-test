<?php

namespace App\Service;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

/**
 * Class SerializerService
 *
 * @package App\Service
 */
class SerializerService
{

    /** @var SerializerInterface */
    private $_serializer;

    /**
     * SerializerService constructor.
     */
    public function __construct()
    {
        $this->_serializer = SerializerBuilder::create()->build();
    }

    /**
     * @param        $data
     * @param string $format
     *
     * @return string
     */
    public function serializer($data, string $format = 'json'): ?string
    {
        return $this->_serializer->serialize($data, $format);
    }

    /**
     * @param string $jsonData
     * @param string $type
     * @param string $format
     *
     * @return mixed
     */
    public function deserializer(string $jsonData, string $type, string $format = 'json')
    {
        return $this->_serializer->deserialize($jsonData, $type, $format);
    }

    /**
     * @param array  $data
     * @param string $type
     * @param string $format
     *
     * @return mixed
     */
    public function normalizer(array $data, string $type, string $format = 'json')
    {
        $jsonData = $this->serializer($data, $format);

        return $this->deserializer($jsonData, $type, $format);
    }
}
<?php

namespace App\Service;

use JMS\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValidatorService
 *
 * @package App\Service
 */
class ValidatorService
{

    private $_validator;

    /**
     * ValidatorService constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->_validator = $validator;
    }

    /**
     * @param $data
     *
     * @return array|void
     */
    public function validate($data): ?array
    {
        $errors = $this->_validator->validate($data);
        $msgErrors = [];

        if (count($errors)) {
            foreach ($errors as $error) {
                $msgErrors[$error->getPropertyPath()] = $error->getMessage();
            }

            return $msgErrors;
        }

        return null;
    }
}
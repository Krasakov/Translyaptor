<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \InvalidArgumentException
{
    /**
     * @var array|string[]
     */
    private $messages;

    /**
     * @param ConstraintViolationListInterface $constraints
     */
    public function __construct(ConstraintViolationListInterface $constraints)
    {
        $this->messages = [];
        foreach ($constraints as $constraint) {
            $this->messages[$constraint->getPropertyPath()] = $constraint->getMessage();
        }

        parent::__construct();
    }

    /**
     * @return string[]
     */
    public function getMessages()
    {
        return $this->messages;
    }
}

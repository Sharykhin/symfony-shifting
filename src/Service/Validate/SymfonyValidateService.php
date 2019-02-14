<?php

namespace App\Service\Validate;

use App\Contract\Factory\ValueObject\ValidatorBagFactoryInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Contract\Service\Validate\ValidateInterface;
use Symfony\Component\Validator\ConstraintViolation;
use App\Request\Constraint\AbstractConstrain;
use App\ValueObject\ValidatorBag;

/**
 * Class SymfonyValidateService
 * @package App\Service\Validate
 */
class SymfonyValidateService implements ValidateInterface
{
    /** @var ValidatorInterface $validator */
    protected $validator;

    /** @var ValidatorBagFactoryInterface $validatorBagFactory */
    protected $validatorBagFactory;

    /**
     * ValidateService constructor.
     * @param ValidatorInterface $validator
     * @param ValidatorBagFactoryInterface $validatorBagFactory
     */
    public function __construct(
        ValidatorInterface $validator,
        ValidatorBagFactoryInterface $validatorBagFactory
    )
    {
        $this->validator = $validator;
        $this->validatorBagFactory = $validatorBagFactory;
    }

    /**
     * @param $values
     * @param $constraintClass
     * @param array|null $groups
     * @return ValidatorBag
     */
    public function validate($values, $constraintClass, array $groups = null): ValidatorBag
    {
        /** @var ConstraintViolationListInterface $violations */
        $violations = $this->validator->validate(
            $values,
            ($this->createConstraintClass($constraintClass))->getConstrain(),
            $groups
        );

        $errors = [];
        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $errors[trim($violation->getPropertyPath(), '[ ]')] = $violation->getMessage();
        }

        /** @var ValidatorBag $validatorBag */
        $validatorBag = $this->validatorBagFactory->create($errors);

        return $validatorBag;
    }

    /**
     * @param string $constraintClass
     * @return AbstractConstrain
     */
    protected function createConstraintClass(string $constraintClass): AbstractConstrain
    {
        return new $constraintClass();
    }
}

<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class CurrencyRequestValidator
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {
    }

    public function validate(array $params): \Traversable
    {
        $constraints = new Assert\Collection([
            'from' => new Assert\Optional([
                new Assert\NotBlank(),
                new Assert\DateTime(), ]),
            'to' => new Assert\Optional([
                new Assert\NotBlank(),
                new Assert\DateTime(), ]),
            'page' => new Assert\Optional([
                new Assert\Range(['min' => 1]), ]),
        ]);

        return $this->validator->validate($params, $constraints);
    }
}

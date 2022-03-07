<?php

namespace Domain\Security\Assert;

use Assert\Assertion as BaseAssertion;
use Assert\LazyAssertionException;
use Domain\Security\Gateway\PlayerRepositoryInterface;

class Assertion extends BaseAssertion
{
    public static function notUniqUserName(string $userName, PlayerRepositoryInterface $repository): void
    {
        if ($repository->getByUserName($userName)) {
            throw new LazyAssertionException("Not unique user name", []);
        }
    }

    public static function notUniqEmail(string $email, PlayerRepositoryInterface $repository): void
    {
        if ($repository->getByEmail($email)) {
            throw new LazyAssertionException("Not unique email", []);
        }
    }

    public static function tooShortPassword(string $plainPassword): void
    {
        if (strlen($plainPassword) < 8) {
            throw new LazyAssertionException("Too short password", []);
        }
    }

    public static function badFormatPassword(string $password): void
    {
        $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z]).{8,}$/';
        if (!preg_match($pattern, $password)) {
            throw new LazyAssertionException("Bad Format password", []);
        }
    }
}

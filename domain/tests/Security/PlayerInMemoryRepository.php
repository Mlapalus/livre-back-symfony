<?php

namespace Domain\Tests\Security;

use Domain\Security\Entity\User;
use Domain\Security\Gateway\PlayerRepositoryInterface;

class PlayerInMemoryRepository implements PlayerRepositoryInterface
{
    private const USED_EMAIL = "used@email.com";
    private const USED_USERNAME = "usedUserName";

    /**
     * @param string $userNames
     * @return User|null
     */
    public function getByUserName(string $userNames): ?User
    {
        return $userNames === self::USED_USERNAME ? new User() : null;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function getByEmail(string $email): ?User
    {
        return $email === self::USED_EMAIL ? new User() : null;
    }

    /**
     * @param User $user
     */
    public function save(User $user): void
    {
    }
}

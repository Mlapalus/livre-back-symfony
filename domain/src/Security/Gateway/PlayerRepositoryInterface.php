<?php

namespace Domain\Security\Gateway;

use Domain\Security\Entity\User;

interface PlayerRepositoryInterface
{
    public function getByUserName(string $userNames): ?User;
    public function getByEmail(string $userNames): ?User;
    public function save(User $user): void;
}

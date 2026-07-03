<?php

declare(strict_types=1);

class AuthRepository
{
    public function findByEmail(string $email): ?array
    {
        $user = UsersQuery::create()
            ->filterByEmail($email)
            ->findOne();
        return $user ? $user->toArray() : null;
    }
}
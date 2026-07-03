<?php

declare(strict_types=1);
class User
{
    public string $name;
    public string $email;
    public string $password_hash;
    public string $role;


    public function __construct(string $name, string $email, string $role)
    {
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
    }

    public function setPassword(string $password): void
    {
        $this->password_hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    
}
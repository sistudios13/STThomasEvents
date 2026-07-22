<?php

declare(strict_types=1);

namespace App\Models;
class Booking
{
    public int $event_id;
    public string $name;
    public string $email;
    public string $phone;
    public string $role;
    public string $token;
    public array $seats;
    public ?int $session_id = null;
    public int $otp;
    public string $code_expires_at;
    public bool $email_verified = false;
    public string $reference;


    public function __construct(int $event_id, array $seats, string $name, string $email, string $phone, string $role)
    {
        $this->event_id = $event_id;
        $this->seats = $seats;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->role = $role;
    }

    public function generateOTP(): void
    {
        $this->otp = rand(100000, 999999);
    }

    public function generateReference(int $length = 6): void
{
    // Human-safe alphabet
    $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    $code = '';
    $maxIndex = \strlen($alphabet) - 1;

    for ($i = 0; $i < $length; $i++) {
        $index = random_int(0, $maxIndex);
        $code .= $alphabet[$index];
    }

    $this->reference = $code;
}

    public function generateToken(): void
    {
        $this->token = bin2hex(random_bytes(50));
    }

    public function setExpiry(int $seconds): void
    {
        $this->code_expires_at = date('Y-m-d H:i:s', time() + $seconds);
    }

    public function isExpired(): bool
    {
        return time() > strtotime($this->code_expires_at);
    }
}
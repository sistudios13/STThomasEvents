<?php

declare(strict_types=1);
class Booking
{
    public int $event_id;
    public string $name;
    public string $email;
    public string $phone;
    public string $token;
    public array $seats;
    public ?int $session_id = null;
    public int $otp;
    public string $code_expires_at;
    public bool $email_verified = false;


    public function __construct(int $event_id, array $seats, string $name, string $email, string $phone)
    {
        $this->event_id = $event_id;
        $this->seats = $seats;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function generateOTP(): void
    {
        $this->otp = rand(100000, 999999);
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
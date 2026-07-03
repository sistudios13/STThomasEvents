<?php

declare(strict_types=1);

class Reservation
{
    public int $event_id;
    public array $seats;
    public ?int $session_id = null;
    public string $token = '';
    public string $expires_at = '';

    public function __construct(int $event_id, array $seats)
    {
        $this->event_id = $event_id;
        $this->seats = $seats;
    }

    public function generateToken(): void
    {
        $this->token = bin2hex(random_bytes(50));
    }

    public function setExpiry(int $seconds): void
    {
        $this->expires_at = date('Y-m-d H:i:s', time() + $seconds);
    }

    public function isExpired(): bool
    {
        return time() > strtotime($this->expires_at);
    }
}

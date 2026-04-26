<?php

class Reservation
{
    public $id;
    public $event_id;
    public $seats;
    public $session_id;
    public $token;
    public $expires_at;

    public function __construct($event_id, $seats)
    {

        $this->event_id = $event_id;
        $this->seats = $seats;

    }

    public function create_session()
    {
        $expiration = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        $token = bin2hex(random_bytes(50));

        $stmt = Database::$con->prepare("INSERT INTO reservation_sessions (token, event_id, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $token, $this->event_id, $expiration);
        $stmt->execute();

        $this->session_id = Database::$con->insert_id;
        $this->token = $token;
        $this->expires_at = $expiration;

        $stmt->close();
    }

    public function save_seats()
    {
        foreach ($this->seats as $seat) {
            $stmt = Database::$con->prepare("INSERT INTO reservations (event_id, seat, session_id, expires_at) VALUES (?, ?, ?, ?)");
            
            $stmt->bind_param("isis", $this->event_id, $seat, $this->session_id, $this->expires_at);
            $stmt->execute();

            $stmt->close();
            
        }
    }

}
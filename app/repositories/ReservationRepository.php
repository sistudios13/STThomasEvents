<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseRepository.php';

class ReservationRepository extends BaseRepository
{
    public function createSession(string $token, int $event_id, string $expires_at): int
    {
        // $stmt = $this->con->prepare(
        //     "INSERT INTO reservation_sessions (token, event_id, expires_at) VALUES (?, ?, ?)"
        // );
        // $stmt->bind_param('sis', $token, $event_id, $expires_at);
        // $stmt->execute();

        // $session_id = $this->con->insert_id;
        // $stmt->close();

        // return $session_id;

        $session = new ReservationSessions();
        $session->setToken($token);
        $session->setEventId($event_id);
        $session->setExpiresAt($expires_at);
        $session->save();

        return $session->getId();

    }

    public function saveSeats(int $session_id, int $event_id, array $seats, string $expires_at): void
    {
        // $stmt = $this->con->prepare(
        //     "INSERT INTO reservations (event_id, seat, session_id, expires_at) VALUES (?, ?, ?, ?)"
        // );

        // foreach ($seats as $seat) {
        //     $stmt->bind_param('isis', $event_id, $seat, $session_id, $expires_at);
        //     $stmt->execute();
        // }

        // $stmt->close();

        
        foreach ($seats as $seat) {
            $reservations = new Reservations();
            $reservations->setEventId($event_id);
            $reservations->setSeat($seat);
            $reservations->setSessionId($session_id);
            $reservations->setExpiresAt($expires_at);
            $reservations->save();
        }
    }

    public function deleteExpired(): void
    {
        // $stmt = $this->con->prepare("DELETE FROM reservation_sessions WHERE expires_at < NOW()");
        // $stmt->execute();
        // $stmt->close();

        $reservations = new ReservationsQuery();
        $reservations->filterByExpiresAt(['min' => date('Y-m-d H:i:s')]);
        $reservations->delete();
    }
}

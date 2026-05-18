<?php

require_once __DIR__ . '/BaseRepository.php';
class TicketsRepository extends BaseRepository
{

    public function authenticateEmailAndCode(string $email, string $code): bool
    {
        // $stmt = $this->con->prepare("SELECT * FROM booking_sessions WHERE email = ? AND reference = ?");
        // $stmt->bind_param('ss', $email, $code);
        // $stmt->execute();
        // $result = $stmt->get_result();
        // $stmt->close();

        // if ($result->num_rows > 0) {
        //     return true;
        // }

        // return false;

        $user = BookingSessionsQuery::Create()
            ->filterByEmail($email)
            ->filterByReference($code)
            ->findOne();

        if (!$user) {
            return false;
        }

        return true;
    }

    public function getTicketDataByCode(string $code): ?array
    {
        // $stmt = $this->con->prepare("SELECT bs.name, bs.event_id, bs.email, bs.reference, e.name AS event_name, e.date AS event_date, GROUP_CONCAT(b.seat ORDER BY b.seat SEPARATOR ',') AS seats FROM booking_sessions bs JOIN bookings b ON bs.id = b.session_id JOIN events e ON bs.event_id = e.id WHERE bs.reference = ? GROUP BY bs.name, bs.email, bs.reference, e.name, e.date");
        // $stmt->bind_param('s', $code);
        // $stmt->execute();
        // $result = $stmt->get_result();
        // $data = $result->fetch_assoc();

        // $stmt->close();
        // return $data ?: null;

        $session = BookingSessionsQuery::create()
            ->filterByReference($code)
            ->joinWith('Events')
            ->joinWith('Bookings')
            ->select(['Name', 'EventId', 'Email', 'Reference', 'Events.Name', 'Events.Date', 'Bookings.Seat'])
            ->find();

        if ($session->getFirst() === null) {
            return null;
        }

        $seats = [];

        foreach ($session as $booking) {
            $seats[] = $booking['Bookings.Seat'];
        }

        sort($seats);

        $seatString = implode(',', $seats);

        return [
            'Name' => $session->getFirst()['Name'],
            'EventId' => $session->getFirst()['EventId'],
            'Email' => $session->getFirst()['Email'],
            'Reference' => $session->getFirst()['Reference'],

            'Events.Name' => $session->getFirst()['Events.Name'],
            'Events.Date' => $session->getFirst()['Events.Date'],

            'Seats' => $seatString
        ];
    }

    public function seatBelongsToCode(string $code, string $seat): bool
    {

        $booking = BookingsQuery::create()
            ->useBookingSessionsQuery()
            ->filterByReference($code)
            ->endUse()
            ->filterBySeat($seat)
            ->findOne();

        if (!$booking) {
            return false;
        }

        return true;
    }

    public function removeSeatFromBooking(string $code, string $seat): void
    {


        $booking = BookingsQuery::create()
            ->useBookingSessionsQuery()
            ->filterByReference($code)
            ->endUse()
            ->filterBySeat($seat)
            ->findOne();

        if ($booking) {
            $booking->delete();

        }

        $session = BookingSessionsQuery::create()
            ->filterByReference($code)
            ->findOne();
        if ($session) {
            $remainingSeats = BookingsQuery::create()
                ->filterBySessionId($session->getId())
                ->count();

            if ($remainingSeats == 0) {
                $session->delete();
            }
        }

    }

}
<?php

declare(strict_types=1);

require_once __DIR__ . '/../repositories/TicketsRepository.php';

use Respect\Validation\Validator as v;

class TicketsService
{
    private TicketsRepository $ticketsRepository;

    public function __construct() {
        $this->ticketsRepository = new TicketsRepository();
    }
    

    public function authenticateTickets(string $email, string $code): bool
    {
        if (!v::email()->validate($email)) {
            throw new InvalidArgumentException("Invalid email format.");
        }

        if (!v::between(5, 200)->validate(strlen($email))) {
            throw new InvalidArgumentException("Email must be between 5 and 200 characters long.");
        }

        if (!v::alnum()->noWhitespace()->length(6, 6)->validate($code)) {
            throw new InvalidArgumentException("Invalid code format. Code must be alphanumeric, without spaces, and 6 characters long.");
        }

        return $this->ticketsRepository->authenticateEmailAndCode($email, $code);
    }

    public function getTicketDataByCode(string $code): ?array
    {
        if (!v::alnum()->noWhitespace()->length(6, 6)->validate($code)) {
            throw new InvalidArgumentException("Invalid code format. Code must be alphanumeric, without spaces, and 6 characters long.");
        }

        $data = $this->ticketsRepository->getTicketDataByCode($code);

        return $data;
    }

    public function removeSeatFromBooking(string $code, string $seat): bool
    {
        if (!v::alnum()->noWhitespace()->length(6, 6)->validate($code)) {
            throw new InvalidArgumentException("Invalid code format. Code must be alphanumeric, without spaces, and 6 characters long.");
        }

        if (!v::regex('/^[A-Z]\d+$/')->validate($seat)) {
            throw new InvalidArgumentException("Invalid seat format. Seat must start with a letter followed by numbers (e.g., A1).");
        }

        if ($this->ticketsRepository->seatBelongsToCode($code, $seat) == false) {
            throw new InvalidArgumentException("The seat does not belong to the booking associated with the provided code.");
        }

        $this->ticketsRepository->removeSeatFromBooking($code, $seat);

        return true;
    }

}
<?php

declare(strict_types=1);

require_once __DIR__ . '/../../core/db.php';

class AttemptLimiter
{
    protected $con;
    private $db;
    public int $max_attempts = 0;
    public ?string $identifier = null;
    public function __construct(string $identifier, int $max_attempts)
    {
        $this->max_attempts = $max_attempts;
        $this->identifier = $identifier;

        $this->db = new Database();
        $this->con = $this->db::$con;
    }

    public function verify(): int|false
    {

        if (empty($this->identifier)) {
            return false;
        }

        // $stmt = $this->con->prepare("SELECT attempts_left FROM attempt_limits WHERE identifier = ?");
        // $stmt->bind_param('s', $this->identifier);
        // $stmt->execute();
        // $result = $stmt->get_result();
        // $attempts_left = $result->fetch_assoc();
        // $attempts_left = $attempts_left['attempts_left'];
        // $max_minus_one = $this->max_attempts - 1;

            $result = AttemptLimitsQuery::create()
                ->filterByIdentifier($this->identifier)
                ->findOne();

            
            $max_minus_one = $this->max_attempts - 1;

        if ($result) {
            $attempts_left = $result->getAttemptsLeft();

            if ($attempts_left > 0) {
                // $stmt = $this->con->prepare("UPDATE attempt_limits SET attempts_left = attempts_left - 1 WHERE identifier = ?");
                // $stmt->bind_param('s', $this->identifier);
                // $stmt->execute();
                // $stmt->close();

                $result->setAttemptsLeft($attempts_left - 1);
                $result->save();

                return $attempts_left - 1;
            } else {
                // $stmt->close();
                return false;
            }

        } else {
            // $stmt = $this->con->prepare("INSERT INTO attempt_limits (identifier, attempts_left) VALUES (?, ?)");
            // $stmt->bind_param('si', $this->identifier, $max_minus_one);
            // $stmt->execute();
            // $stmt->close();

            $attempt_limit = new AttemptLimits();
            $attempt_limit->setIdentifier($this->identifier);
            $attempt_limit->setAttemptsLeft($max_minus_one);
            $attempt_limit->save();

            return $this->max_attempts - 1;
        }
    }


}
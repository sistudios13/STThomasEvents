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

            $result = AttemptLimitsQuery::create()
                ->filterByIdentifier($this->identifier)
                ->findOne();

            
            $max_minus_one = $this->max_attempts - 1;

        if ($result) {
            $attempts_left = $result->getAttemptsLeft();

            if ($attempts_left > 0) {
                $result->setAttemptsLeft($attempts_left - 1);
                $result->save();

                return $attempts_left - 1;
            } else {
                return false;
            }

        } else {

            $attempt_limit = new AttemptLimits();
            $attempt_limit->setIdentifier($this->identifier);
            $attempt_limit->setAttemptsLeft($max_minus_one);
            $attempt_limit->save();

            return $this->max_attempts - 1;
        }
    }


}
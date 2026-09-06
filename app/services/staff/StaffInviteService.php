<?php

declare(strict_types=1);

namespace App\Staff\Services;

use Delight\Auth;
use Dotenv;
use App\Repositories\Staff\StaffInviteRepository;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../config');
$dotenv->load();

class StaffInviteService
{
    private \PDO $db;
    private Auth\Auth $auth;
    private \App\Services\EmailService $emailService;
    private StaffInviteRepository $inviteRepository;

    public function __construct()
    {
        $this->db = new \PDO('mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'] . ';charset=utf8mb4', $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->auth = new Auth\Auth($this->db);
        $this->emailService = new \App\Services\EmailService();
        $this->inviteRepository = new StaffInviteRepository();
    }

    public function createAndSendInvite(string $email, string $name): bool
    {
        // Generate unique token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

        // Check if invite already exists for this email
        if ($this->inviteRepository->findValidByEmail($email)) {
            throw new \Error('An invite has already been sent to this email address.');
        }

        // Create invite
        if (!$this->inviteRepository->create($email, $name, $token, $expiresAt)) {
            throw new \Error('Failed to create invite.');
        }

        // Send email
        $registrationLink = \App\Config\Settings::APP_URL . 'staff/register/' . $token;
        $subject = 'You\'re invited to join St. Thomas Events Staff';
        $body = "
            <h2>Welcome, $name!</h2>
            <p>You've been invited to join the St. Thomas Events staff portal.</p>
            <p><a href='$registrationLink' style='display: inline-block; padding: 10px 20px; background-color: #4f46e5; color: white; text-decoration: none; border-radius: 5px;'>Complete Your Registration</a></p>
            <p>This link expires in 7 days.</p>
            <p>If you didn't expect this invitation, you can safely ignore this email.</p>
        ";

        return $this->emailService->sendEmail($email, $name, $subject, $body);
    }

    public function getInviteByToken(string $token): array|false
    {
        return $this->inviteRepository->findByToken($token) ?: false;
    }

    public function completeInvite(string $token, string $password): bool
    {
        $invite = $this->getInviteByToken($token);

        if (!$invite) {
            throw new \Error('Invalid or expired invite token.');
        }

        try {
            // Create user with Delight\Auth
            $userId = $this->auth->register($invite['Email'], $password, $invite['Name']);

            // Mark invite as used
            if (!$this->inviteRepository->markAsUsed($token)) {
                throw new \Error('Failed to mark invite as used.');
            }

            return true;
        } catch (Auth\InvalidEmailException) {
            throw new \Error('Invalid email address.');
        } catch (Auth\InvalidPasswordException) {
            throw new \Error('Password does not meet security requirements.');
        } catch (Auth\UserAlreadyExistsException) {
            throw new \Error('This email address is already registered.');
        } catch (\Exception $e) {
            throw new \Error('Failed to create account: ' . $e->getMessage());
        }
    }

    public function getInvites(): array
    {
        return $this->inviteRepository->getInvites();
    }

    public function deleteInvite(int $id): bool
    {
        return $this->inviteRepository->deleteInvite($id);
    }
}

<?php

declare(strict_types=1);

namespace App\Repositories\Staff;

use Propel\Runtime\ActiveQuery\Criteria;
use StaffInvitesQuery;
use StaffInvites;

class StaffInviteRepository
{
    public function findValidByEmail(string $email): ?array
    {
        $invite = StaffInvitesQuery::create()
            ->filterByEmail($email)
            ->filterByExpiresAt(['min' => new \DateTime])
            ->findOne();

        return $invite ? $invite->toArray() : null;
    }

    public function findByToken(string $token): ?array
    {
        $invite = StaffInvitesQuery::create()
            ->filterByToken($token)
            ->filterByUsedAt(null)
            ->filterByExpiresAt(['min' => new \DateTime])
            ->findOne();

        return $invite ? $invite->toArray() : null;
    }

    public function create(string $email, string $name, string $token, string $expiresAt): bool
    {
        try {
            $invite = new StaffInvites();
            $invite->setEmail($email);
            $invite->setName($name);
            $invite->setToken($token);
            $invite->setExpiresAt(new \DateTime($expiresAt));
            $invite->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function markAsUsed(string $token): bool
    {
        try {
            $invite = StaffInvitesQuery::create()
                ->filterByToken($token)
                ->findOne();

            if (!$invite) {
                return false;
            }

            $invite->setUsedAt(new \DateTime);
            $invite->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getInvites(): array
    {
        $invites = StaffInvitesQuery::create()
            ->orderByCreatedAt(Criteria::DESC)
            ->find();

        return $invites->toArray();
    }

    public function deleteInvite(int $id): bool
    {
        try {
            $invite = StaffInvitesQuery::create()
                ->filterById($id)
                ->findOne();

            if (!$invite) {
                return false;
            }

            $invite->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

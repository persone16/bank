<?php

namespace App\Repositories;

use App\Exceptions\DatabaseException;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Interfaces\DatabaseRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository implements DatabaseRepositoryInterface
{
    public function getAll(int $receiverId): Collection
    {
        // TODO: Implement getAll() method.
    }

    public function store(array $data): object
    {
        // TODO: Implement store() method.
    }

    public function getById(int $recordId, int $ownerId): object
    {
        // TODO: Implement getById() method.
    }

    public function find(int $id)
    {
        return User::find($id);
    }

    public function update(User $user, array $data): User
    {
        try {
            $user->update($data);

            return $user;
        } catch (Exception $exception) {
            throw new DatabaseException("Error during update a note");
        }
    }
}
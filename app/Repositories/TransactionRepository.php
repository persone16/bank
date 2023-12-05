<?php

namespace App\Repositories;

use App\DataTransferObjects\TransactionData;
use App\Exceptions\DatabaseException;
use App\Repositories\Interfaces\DatabaseRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements DatabaseRepositoryInterface
{
    /**
     * Get all items
     *
     * @param int $receiverId
     *
     * @return mixed
     */
    public function getAll(int $receiverId): Collection {
        return DB::table('transactions')
            ->where('receiver_id', $receiverId)
            ->get();
    }

    /**
     * Get a item
     *
     * @param int $recordId
     * @param int $receiverId
     *
     * @return mixed
     *
     * @throws DatabaseException
     */
    public function getById(int $recordId, int $receiverId): TransactionData
    {
        try {
            $transaction =  TransactionData::from(
                DB::table('transactions')
                    ->where('id', $recordId)
                    ->where('receiver_id', $receiverId)
                    ->first()
            );

            if (empty($transaction->transaction_number)) {
                throw new Exception();
            }

            return $transaction;
        } catch (Exception $exception) {
            throw new DatabaseException("Error during get a item");
        }
    }
}
<?php

namespace App\Services;

use App\DataTransferObjects\TransactionData;
use App\Exceptions\DatabaseException;
use App\Repositories\Interfaces\DatabaseRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TransactionService
{
    public function __construct(public DatabaseRepositoryInterface $transactionRepository, public Request $request)
    { }

    /**
     * Get all Transactions
     *
     * @return Collection
     */
    public function getTransactions(): Collection
    {
        $userId = $this->request->user()->id;

        return $this->transactionRepository->getAll($userId);
    }

    /**
     * Get a Transaction
     *
     * @param int $recordId
     *
     * @return TransactionData
     *
     * @throws DatabaseException
     */
    public function getTransaction(int $recordId): TransactionData
    {
        $userId = $this->request->user()->id;

        try {
            return $this->transactionRepository->getById($recordId, $userId);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
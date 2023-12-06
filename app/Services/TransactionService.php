<?php

namespace App\Services;

use App\DataTransferObjects\TransactionData;
use App\Exceptions\DatabaseException;
use App\Models\Transaction;
use App\Repositories\Interfaces\DatabaseRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class TransactionService
{
    public function __construct(
        public DatabaseRepositoryInterface $transactionRepository,
        public Request $request
    ) { }

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
     * Store a Transaction
     *
     * @param TransactionData $data
     *
     * @return Transaction
     *
     * @throws DatabaseException
     */
//    public function setTransaction(TransactionData $data): Transaction
    public function setTransaction($request): Transaction
    {
//        $data = TransactionData::fromRequest($request->validated());
        $transactionData = TransactionData::fromRequest($request);

        $transactionData->receiver_id        = $this->request->user()->id;
        $transactionData->title              = "пополнение";
        $transactionData->transaction_number = Str::uuid();

        return $this->transactionRepository->store($transactionData->all());
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

        return $this->transactionRepository->getById($recordId, $userId);
    }


}
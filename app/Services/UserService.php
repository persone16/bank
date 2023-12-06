<?php

namespace App\Services;

use App\DataTransferObjects\TransactionData;
use App\DataTransferObjects\UserData;
use App\Exceptions\DatabaseException;
use App\Repositories\Interfaces\DatabaseRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        public DatabaseRepositoryInterface $userRepository,
        public Request $request
    ) { }

    public function fillBalance($request)
    {
        $userId = $this->request->user()->id;
        $user = $this->userRepository->find($userId);

        $sum = $request->input('sum');

        $updatedBalance = (int) $user->balance + (int) $sum;

        $this->userRepository->update($user, [
            "balance" => $updatedBalance
        ]);
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
    public function getUser(int $recordId): TransactionData
    {
        $userId = $this->request->user()->id;

        return $this->transactionRepository->getById($recordId, $userId);
    }
}
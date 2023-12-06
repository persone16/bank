<?php

namespace App\Http\Controllers;

use App\Exceptions\DatabaseException;
use App\Http\Library\ApiHelpers;
use App\Http\Requests\Transactions\StoreRequest;
use App\Services\TransactionService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    use ApiHelpers;

    public function __construct(
        public TransactionService $transactionService,
        public UserService $userService,
    ) {}

    public function transaction(): JsonResponse
    {
        $transactions = $this->transactionService->getTransactions();

        return $this->onSuccess($transactions, 'Transactions Retrieved');
    }

    /**
     * @throws DatabaseException
     */
    public function singleTransaction($id): JsonResponse
    {
        $transaction = $this->transactionService->getTransaction($id);

        return $this->onSuccess($transaction, 'Transaction Retrieved');
    }

    /**
     * Пополнение баланса
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function replenishTransaction(StoreRequest $request): JsonResponse {
        DB::beginTransaction();
        try {
            // set transaction
            $this->transactionService->setTransaction($request);

            // set balance
            $this->userService->fillBalance($request);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return $this->onError(400, $exception->getMessage());
        }

        return $this->onSuccess('', 'Transaction made successful');
    }

    /**
     * Перевод средств между пользователями
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function moneyTransaction(Request $request): JsonResponse
    {
        // 1. проверить получателя на существование
        $receiverId = $request->input('receiver_id');
        $receiver = DB::table('users')->find($receiverId);
        if (empty($receiver)) {
            return $this->onError(400, 'Receiver not found');
        }

        $sum = (int) $request->input('sum');
        // 2. проверить баланс отправителя на хватку средств
        $senderId = $request->user()->id;
        $sender = DB::table('users')->find($senderId);
        $futureBalance = (int) $sender->balance - $sum;
        if ($futureBalance < 0) {
            return $this->onError(400, 'Sender not have enough money on balance');
        }

        // 3. отправка суммы
        DB::beginTransaction();
        try {
            // 3.1 сделать транзакцию на отправку
            DB::table('transactions')->insert([
                "transaction_number" => Str::uuid(),
                "title"              => "перевод",
                "sender_id"          => $senderId,
                "receiver_id"        => $receiverId,
                "sum"                => $sum,
            ]);

            // 3.2 вычесть у отправителя
            DB::table('users')
                ->where('id', $senderId)
                ->update([
                    "balance" => (int) $sender->balance - $sum
                ]);

            // 3.3 добавить получателю
            DB::table('users')
                ->where('id', $receiverId)
                ->update([
                    "balance" => (int) $receiver->balance + $sum
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->onError(400, 'Transaction wrong');
        }

        return $this->onSuccess(200, 'Transaction made successful, check your balance');
    }
}
<?php

namespace App\DataTransferObjects;

use Spatie\LaravelData\Data;

class TransactionData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $transaction_number,
        public readonly ?string $type,
        public readonly ?string $title,
        public readonly ?int $sender_id,
        public readonly ?int $receiver_id,
    ) {}
}
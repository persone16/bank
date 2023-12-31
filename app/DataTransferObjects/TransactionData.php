<?php

namespace App\DataTransferObjects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\Request;
use Spatie\LaravelData\Data;

class TransactionData extends Data
{
    public function __construct(
        public int $sum,
        public ?int $id = null,
        public ?string $transaction_number = null,
        public ?string $title = null,
        public ?int $sender_id = null,
        public ?int $receiver_id = null,
    ) {}

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            $request->input('sum')
        );
    }
}
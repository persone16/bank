<?php

namespace App\DataTransferObjects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\Request;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public int $balance,
        public ?int $id = null,
    ) {}

    public static function fromRequest(FormRequest $request): self
    {
        return new self(
            $request->input('balance')
        );
    }
}
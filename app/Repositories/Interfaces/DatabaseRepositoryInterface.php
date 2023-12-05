<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface DatabaseRepositoryInterface {
    /**
     * Get all
     *
     * @param int $receiverId
     *
     * @return mixed
     */
    public function getAll(int $receiverId): Collection;


}
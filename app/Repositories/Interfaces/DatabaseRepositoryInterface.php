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

    /**
     * Store
     *
     * @param array $data
     *
     * @return Object
     */
    public function store(array $data): Object;

    /**
     * Get record by id
     *
     * @param int $recordId
     * @param int $ownerId
     *
     * @return Object
     */
    public function getById(int $recordId, int $ownerId): Object;

//    /**
//     * Update
//     *
//     * @param $object
//     * @param array $data
//     *
//     * @return Transaction
//     */
//    public function update($object, array $data): Object;

}
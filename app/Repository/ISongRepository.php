<?php

namespace App\Repository;

/**
 * Interface ISongRepository
 * @package App\Repository
 */
interface ISongRepository
{
    /**
     * @param int $page
     * @param int $perPage
     * @return mixed
     */
    public function page(int $page = 1, int $perPage = 15);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id);

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);
}

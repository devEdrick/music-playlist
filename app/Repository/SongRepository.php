<?php

namespace App\Repository;

use App\Models\Song;

/**
 * Class SongRepository
 * @package App\Repository
 */
class SongRepository implements ISongRepository
{
    /**
     * @param int $page
     * @param int $perPage
     * @return mixed
     */
    public function page(int $page = 1, int $perPage = 15)
    {
		$offset = ($page - 1) * $perPage;

        return Song::latest()->limit($perPage)->offset($offset)->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return Song::find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data )
    {
        return Song::create($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update(array $data, int $id)
    {
        $song = Song::find($id);

        if($song)
        {
            $song->update($data);

            return $song;
        }

        return $song;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        $song = Song::find($id);

        if($song)
        {
            return $song->delete();
        }

        return $song;
    }
}

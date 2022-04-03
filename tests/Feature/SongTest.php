<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SongTest extends TestCase
{

    public function callCreateSongApi()
    {
        $response = $this->post('api/v1/songs', [
            'title' => 'Test Song Title',
            'url' => 'http://localhost',
            'duration' => 10,
            'artist_name' => 'Test Song Artist'
        ]);

        return $response;
    }

    /**
     * @test
     *
     * @return void
     */
    public function get_songs_list()
    {
        $response = $this->get("api/v1/songs?page=1");
        
        Log::info(__FUNCTION__, [$response->getContent()]);

        $response->assertOk();
    }

    /**
     * @test
     *
     * @return void
     */
    public function get_song_details()
    {
        $response = $this->callCreateSongApi();

        $id = json_decode($response->getContent())->data->id ?? null;

        Log::info(__FUNCTION__, [$response->getContent()]);

        $response->assertOk();

        if($id)
        {
            $response = $this->get("api/v1/songs/{$id}");

            Log::info(__FUNCTION__, [$response->getContent()]);

            $response->assertOk();

            $response = $this->delete("api/v1/songs/{$id}");

            Log::info(__FUNCTION__, [$response->getContent()]);

            $response->assertOk();
        }
    }
    
    /**
     * @test
     *
     * @return void
     */
    public function a_song_can_be_added_to_playlist()
    {
        $response = $this->callCreateSongApi();

        $id = json_decode($response->getContent())->data->id ?? null;

        Log::info(__FUNCTION__, [$response->getContent()]);

        $response->assertOk();

        if($id)
        {
            $response = $this->delete("api/v1/songs/{$id}");

            Log::info(__FUNCTION__, [$response->getContent()]);

            $response->assertOk();
        }
    }

    /**
     * @test
     * 
     * @return void
     */
    public function a_song_can_be_updated()
    {
        $response = $this->callCreateSongApi();

        $id = json_decode($response->getContent())->data->id ?? null;

        Log::info(__FUNCTION__, [$response->getContent()]);

        $response->assertOk();

        if($id)
        {
            $response = $this->put("api/v1/songs/{$id}", 
            [
                'title' => 'Test Song Title',
                'url' => 'http://localhost',
                'duration' => 10,
                'artist_name' => 'Test Song Artist'
            ]);

            Log::info(__FUNCTION__, [$response->getContent()]);

            $response->assertOk();

            $response = $this->delete("api/v1/songs/{$id}");
            
            Log::info(__FUNCTION__, [$response->getContent()]);

            $response->assertOk();
        }
    }

    /**
     * @test
     * 
     * @return void
     */
    public function a_song_can_be_deleted()
    {
        $response = $this->callCreateSongApi();

        $id = json_decode($response->getContent())->data->id ?? null;

        Log::info(__FUNCTION__, [$response->getContent()]);
        
        $response->assertOk();

        if($id)
        {
            $response = $this->delete("api/v1/songs/{$id}");
            
            Log::info(__FUNCTION__, [$response->getContent()]);

            $response->assertOk();
        }
    }

    /**
     * @test
     *
     * @return void
     */
    public function a_song_title_is_required()
    {
        $response = $this->post('api/v1/songs', [
            'title' => '',
            'url' => 'http://localhost',
            'duration' => 10,
            'artist_name' => 'Test Song Artist'
        ]);

        Log::info(__FUNCTION__, [$response->getContent()]);

        $response->assertUnprocessable();
    }

    /**
     * @test
     *
     * @return void
     */
    public function a_song_url_is_required()
    {
        $response = $this->post('api/v1/songs', [
            'title' => 'Test Song Title',
            'url' => '',
            'duration' => 10,
            'artist_name' => 'Test Song Artist'
        ]);

        Log::info(__FUNCTION__, [$response->getContent()]);

        $response->assertUnprocessable();
    }

    /**
     * @test
     *
     * @return void
     */
    public function a_song_duration_is_required()
    {
        $response = $this->post('api/v1/songs', [
            'title' => 'Test Song Title',
            'url' => 'http://localhost',
            'duration' => '',
            'artist_name' => 'Test Song Artist'
        ]);

        Log::info(__FUNCTION__, [$response->getContent()]);

        $response->assertUnprocessable();
    }

    /**
     * @test
     *
     * @return void
     */
    public function a_song_artist_name_is_required()
    {
        $response = $this->post('api/v1/songs', [
            'title' => 'Test Song Title',
            'url' => 'http://localhost',
            'duration' => 10,
            'artist_name' => ''
        ]);

        Log::info(__FUNCTION__, [$response->getContent()]);

        $response->assertUnprocessable();
    }
}

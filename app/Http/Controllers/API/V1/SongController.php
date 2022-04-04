<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SongResource;
use App\Repository\ISongRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

/**
 * Class SongController
 * @package App\Http\Controllers\API\V1
 */
class SongController extends Controller
{
    /**
     * @var ISongRepository
     */
    protected ISongRepository $repository;

    /**
     * SongController constructor.
     * @param ISongRepository $repository
     */
    public function __construct(ISongRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *      path="/api/v1/songs",
     *      operationId="getSongsList",
     *      tags={"Song"},
     *      summary="Get Songs",
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=404, description="Not Found"),
     *      @OA\Response(response=500, description="Internal Server Error"),
     *
     *      @OA\Parameter(name="page", in="query", description="Page", required=false, @OA\Schema(type="integer")),
     *      @OA\Parameter(name="per_page", in="query", description="Page Size", required=false, @OA\Schema(type="integer")),
     *     )
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $page = request()->get('page') ?? 1;
        $perPage = request()->get('per_page') ?? 15;

        return response()->json(['status' => true, 'message' => 'Songs fetched successfully.' ,'data' => (new SongResource($this->repository->page($page, $perPage)))]);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/songs",
     *      operationId="storeSong",
     *      tags={"Song"},
     *      summary="Create Song",
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=404, description="Not Found"),
     *      @OA\Response(response=500, description="Internal Server Error"),
     *      @OA\Response(response=422, description="Unprocessable Entitiy"),
     *
     *      @OA\Parameter(name="title", in="query", description="Song Title", required=true, @OA\Schema(type="string")),
     *      @OA\Parameter(name="url", in="query", description="Song Url", required=true, @OA\Schema(type="string")),
     *      @OA\Parameter(name="duration", in="query", description="Song Duration (Seconds)", required=true, @OA\Schema(type="integer")),
     *      @OA\Parameter(name="artist_name", in="query", description="Song Artist Name", required=true, @OA\Schema(type="string"))
     *     )
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|max:255',
            'url'         => 'required|url',
            'duration'    => 'required|integer',
            'artist_name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Store new song
        $song = $this->repository->create($validator->validated());

        return response()->json(['status' => true, 'message' => 'Song created successfully.', 'data' => new SongResource($song)], Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/songs/{id}",
     *      operationId="showSong",
     *      tags={"Song"},
     *      summary="Get Song",
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=404, description="Not Found"),
     *      @OA\Response(response=500, description="Internal Server Error"),
     *
     *      @OA\Parameter(name="id", in="path", description="Song Id", required=true, @OA\Schema(type="integer")),
     *     )
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        $song = $this->repository->find($id);
        if ($song) {
            return response()->json(['status' => true, 'message' => 'Song fetched successfully.', 'data' => new SongResource($song)]);
        }
        return response()->json(['status' => false, 'message' => 'Song not found.'], Response::HTTP_NOT_FOUND);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/songs/{id}",
     *      operationId="updateSong",
     *      tags={"Song"},
     *      summary="Update Song",
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=404, description="Not Found"),
     *      @OA\Response(response=500, description="Internal Server Error"),
     *      @OA\Response(response=422, description="Unprocessable Entitiy"),
     *
     *      @OA\Parameter(name="id", in="path", description="Song Id", required=true, @OA\Schema(type="integer")),
     *      @OA\Parameter(name="title", in="query", description="Song Title", required=true, @OA\Schema(type="string")),
     *      @OA\Parameter(name="url", in="query", description="Song Url", required=true, @OA\Schema(type="string")),
     *      @OA\Parameter(name="duration", in="query", description="Song Duration (Seconds)", required=true, @OA\Schema(type="integer")),
     *      @OA\Parameter(name="artist_name", in="query", description="Song Artist Name", required=true, @OA\Schema(type="string"))
     *     )
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|max:255',
            'url'         => 'required|url',
            'duration'    => 'required|integer',
            'artist_name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Update song details
        $song = $this->repository->update($validator->validated(), $id);
        if ($song) {
            return response()->json(['status' => true, 'message' => 'Song updated successfully.', 'data' => new SongResource($song)], Response::HTTP_OK);
        }

        return response()->json(['status' => false, 'message' => 'Song not found.'], Response::HTTP_NOT_FOUND);
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/songs/{id}",
     *      operationId="deleteSong",
     *      tags={"Song"},
     *      summary="Delete Song",
     *      @OA\Response(response=200, description="Ok"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=404, description="Not Found"),
     *      @OA\Response(response=500, description="Internal Server Error"),
     *
     *      @OA\Parameter(name="id", in="path", description="Song Id", required=true, @OA\Schema(type="integer")),
     *     )
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        if ($this->repository->delete($id)) {
            return response()->json(['status' => true, 'message' => 'Song deleted successfully.'], Response::HTTP_OK);
        }

        return response()->json(['status' => false, 'message' => 'Song not found.'], Response::HTTP_NOT_FOUND);
    }
}

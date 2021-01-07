<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class MovieController extends Controller
{
    private $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * @return JsonResponse
     */
    public function getTitles(): JsonResponse
    {
        $items = Cache::remember('titles', 60, function () {
            return retry(5, function () {
                return $this->movieService->collectAllMovies();
            }, 100);
        });

        return response()->json($items);
    }
}

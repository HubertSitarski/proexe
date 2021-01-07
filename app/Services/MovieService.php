<?php

namespace App\Services;

use Generator;
use External\Foo\Movies\MovieService as FooMovieService;
use External\Bar\Movies\MovieService as BarMovieService;
use External\Baz\Movies\MovieService as BazMovieService;
use Illuminate\Support\Collection;

class MovieService
{
    private $barMovieService;
    private $fooMovieService;
    private $bazMovieService;

    public function __construct(
        FooMovieService $fooMovieService,
        BarMovieService $barMovieService,
        BazMovieService $bazMovieService
    ) {
        $this->fooMovieService = $fooMovieService;
        $this->barMovieService = $barMovieService;
        $this->bazMovieService = $bazMovieService;
    }

    public function collectAllMovies(): Collection
    {
        $collection = new Collection();

        foreach ($this->collectFooMoviesGenerator() as $item) {
            $collection = $collection->push($item);
        }

        foreach ($this->collectBarMoviesGenerator() as $item) {
            $collection = $collection->push($item);
        }

        foreach ($this->collectBazMoviesGenerator() as $item) {
            $collection = $collection->push($item);
        }

        return $collection;
    }

    private function collectFooMoviesGenerator(): Generator
    {
        foreach ($this->fooMovieService->getTitles() as $title) {
            yield $title;
        }
    }

    private function collectBarMoviesGenerator(): Generator
    {
        foreach ($this->barMovieService->getTitles()['titles'] as $title) {
            yield $title['title'];
        }
    }

    private function collectBazMoviesGenerator(): Generator
    {
        foreach ($this->bazMovieService->getTitles()['titles'] as $title) {
            yield $title;
        }
    }
}

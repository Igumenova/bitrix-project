<?php

use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Loader;
use Test\Movies\Controller\Movie;
use Bitrix\Main\Engine\ActionFilter;


class MoviesRestComponent extends CBitrixComponent implements Controllerable
{


    public function configureActions()
    {
        return [
            'list' => [
                'prefilters' => []
            ],
            'genres' => [
                'prefilters' => []
            ],
            'tags' => [
                'prefilters' => []
            ],
            'countries' => [
                'prefilters' => []
            ],
            'detail' => [
                'prefilters' => []
            ]
        ];
    }

    public function listAction($page = 1, $genreId = null, $country = null, $tags = [], $search = '', $pageSize = 10)
    {
        Loader::includeModule('test.movies');

        return (new Movie())->listAction(
            $page,
            $genreId,
            $tags,
            $country,
            $search,
            $pageSize
        );
    }

    public function genresAction()
    {
        Loader::includeModule('test.movies');
        return (new Movie())->genresAction();
    }

    public function tagsAction()
    {
        Loader::includeModule('test.movies');
        return (new Movie())->tagsAction();
    }

    public function countriesAction()
    {
        Loader::includeModule('test.movies');
        return (new Movie())->countriesAction();
    }

    public function detailAction($id)
    {
        Loader::includeModule('test.movies');
        return (new Movie())->detailAction($id);
    }

}
<?php
namespace Test\Movies\Controller;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Loader;
use CFile;

class Movie extends Controller
{

    public function configureActions()
    {
        return [
            'list' => ['prefilters' => []],
            'genres' => ['prefilters' => []],
            'detail' => ['prefilters' => []],
            'tags' => ['prefilters' => []],
            'countries' => ['prefilters' => []],
        ];
    }

    public function listAction(
        $page = 1,
        $genreId = null,
        $tags = [],
        $country = null,
        $search = '',
        $pageSize = 10
    )
    {
        Loader::includeModule('iblock');

        $filter = [
            'IBLOCK_ID' => 4,
            'ACTIVE' => 'Y',
        ];

        if ($genreId) {
            $filter['PROPERTY_GENRE'] = $genreId;
        }

        if ($country) {
            $filter['PROPERTY_COUNTRY'] = $country;
        }

        if (!empty($tags)) {
            $andTags = ['LOGIC' => 'AND'];
            foreach ($tags as $tagId) {
                $andTags[] = [
                    'ID' => \CIBlockElement::SubQuery('ID', [
                        'IBLOCK_ID' => 4,
                        'PROPERTY_TAGS' => $tagId
                    ])
                ];
            }
            $filter[] = $andTags; 
        }
        
        if (!empty($search)) {
            $filter['%NAME'] = $search;
        }

        $page = max(1, (int)$page);

        $totalCount = \CIBlockElement::GetList([], $filter, false, false, ['ID'])->SelectedRowsCount();
        $totalPages = ceil($totalCount / $pageSize);

        $res = \CIBlockElement::GetList(
            ['ID' => 'DESC'],
            $filter,
            false,
            ['nPageSize' => $pageSize, 'iNumPage' => $page],
            ['ID', 'NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE']
        );

        $items = [];

        while ($item = $res->Fetch()) {

            $props = [];
            $propRes = \CIBlockElement::GetProperty(4, $item['ID']);

            while ($prop = $propRes->Fetch()) {
                if (!empty($prop['VALUE'])) {

                    if ($prop['MULTIPLE'] === 'Y') {
                        $props[$prop['CODE']][] = $prop['VALUE'];
                    } else {
                        $props[$prop['CODE']] = $prop['VALUE'];
                    }
                }
            }

            $pictureUrl = null;

            if ($item['PREVIEW_PICTURE']) {
                $picturePath = CFile::GetPath($item['PREVIEW_PICTURE']);
                if ($picturePath) {
                    $pictureUrl = 'http://176.108.254.225' . $picturePath;
                }
            }

            $items[] = [
                'id' => (int)$item['ID'],
                'title' => $item['NAME'],
                'description' => $item['PREVIEW_TEXT'] ?? '',
                'year' => $props['YEAR'] ?? null,
                'tags' => $props['TAGS'] ?? [],
                'country' => $props['COUNTRY'] ?? null,
                'previewPicture' => $pictureUrl,
            ];
        }

        return [
            'items' => $items,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
    }

        public function genresAction()
        {
            Loader::includeModule('iblock');

            $genres = [];
            $res = \CIBlockPropertyEnum::GetList([], ['IBLOCK_ID' => 4, 'CODE' => 'GENRE']);
            while ($genre = $res->Fetch()) {
                $genres[] = [
                    'id' => $genre['ID'],
                    'name' => $genre['VALUE'],
                    'xmlId' => $genre['XML_ID'],
                ];
            }

            return $genres;
        }


    public function detailAction($id)
    {
        Loader::includeModule('iblock');

        $id = (int)$id; 

        if ($id <= 0) {
            return ['error' => 'Invalid ID'];
        }

        $item = \CIBlockElement::GetByID($id)->GetNextElement();
        if (!$item) {
            return ['error' => 'Not found'];
        }

        $fields = $item->GetFields();
        $props = $item->GetProperties();

        return [
            'id' => $fields['ID'],
            'title' => $fields['NAME'],
            'description' => $fields['PREVIEW_TEXT'],
            'details' => $fields['DETAIL_TEXT'],
            'year' => $props['YEAR']['VALUE'] ?? null,
            'genre' => $props['GENRE']['VALUE'] ?? null,
            'director' => $props['DIRECTOR']['VALUE'] ?? null,
            'country' => $props['COUNTRY']['VALUE'] ?? null,
            'duration' => $props['DURATION']['VALUE'] ?? null,
            'age' => $props['AGE']['VALUE'] ?? null,
            'tags' => $props['TAGS']['VALUE'] ?? [],
            'previewPicture' => $fields['PREVIEW_PICTURE'] ? 'http://176.108.254.225' . CFile::GetPath($fields['PREVIEW_PICTURE']) : null,
            'detailPicture' => $fields['DETAIL_PICTURE'] ? 'http://176.108.254.225' . CFile::GetPath($fields['DETAIL_PICTURE']) : null,
        ];
    }

    public function tagsAction()
    {
        Loader::includeModule('iblock');

        $tags = [];

        $res = \CIBlockPropertyEnum::GetList(
            [],
            ['IBLOCK_ID' => 4, 'CODE' => 'TAGS']
        );

        while ($tag = $res->Fetch()) {
            $tags[] = [
                'id' => $tag['ID'],
                'name' => $tag['VALUE'],
                'xmlId' => $tag['XML_ID'],
            ];
        }

        return $tags;
    }

    public function countriesAction()
    {
        Loader::includeModule('iblock');

        $countries = [];

        $res = \CIBlockPropertyEnum::GetList(
            [],
            ['IBLOCK_ID' => 4, 'CODE' => 'COUNTRY']
        );

        while ($country = $res->Fetch()) {
            $countries[] = [
                'id' => $country['ID'],
                'name' => $country['VALUE'],
                'xmlId' => $country['XML_ID'],
            ];
        }

        return $countries;
    }
}
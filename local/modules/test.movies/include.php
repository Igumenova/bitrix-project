<?php
\Bitrix\Main\Loader::registerAutoLoadClasses(
    'test.movies',
    [
        'Test\\Movies\\Controller\\Movie' => 'lib/Controller/Movie.php',
    ]
);
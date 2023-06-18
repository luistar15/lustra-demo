<?php

return [
    'routes' => [
        'home' => '',

        'genres' => [[
            'list'    => '',
            'details' => '{genre_id}',
        ]],

        'artists' => [[
            'list'    => '',
            'details' => '{artist_id}',
        ]],

        'albums' => [[
            'list'    => '',
            'details' => '{album_id}',
        ]],
    ],

    'constraints' => [
        'genre_id'  => 'digit',
        'artist_id' => 'digit',
        'album_id'  => 'digit',
    ],
];

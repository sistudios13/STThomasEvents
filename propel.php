<?php

return [
    'propel' => [
        'database' => [
            'connections' => [
                'stthomas-events' => [
                    'adapter'    => 'mysql',
                    'classname'  => 'Propel\Runtime\Connection\DebugPDO',
                    'dsn'        => 'mysql:host=localhost;dbname=stthomas_events',
                    'user'       => 'root',
                    'password'   => '',
                    'attributes' => []
                ],
            ]
        ],
        'runtime' => [
            'defaultConnection' => 'stthomas-events',
            'connections' => ['stthomas-events', 'stthomas-events']
        ],
        'generator' => [
            'defaultConnection' => 'stthomas-events',
            'connections' => ['stthomas-events']
        ]
    ]
];
<?php

use Symfony\Component\Dotenv\Dotenv;

if (is_file(__DIR__ . '/../../.env')) {
    $dotenv = new Dotenv();
    $dotenv->load(__DIR__ . '/../../.env');
}

return [
    'doctrine' => [
        'connection' => [
            // default connection name
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'params' => [
                    'host' => getenv('MYSQL_HOST'),
                    'port' => getenv('MYSQL_PORT'),
                    'user' => getenv('MYSQL_USER'),
                    'password' => getenv('MYSQL_PASSWORD'),
                    'dbname' => getenv('MYSQL_DATABASE'),
                ],
            ],
        ],
    ],
];

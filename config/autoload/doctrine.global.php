<?php

return [
    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `default_driver`
            'default_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../../module/Application/src/Entity',
                    __DIR__.'/../../module/Application/src/Repository',
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `default_driver` for any entity under namespace `My\Namespace`
                    'Application\Entity' => 'default_driver',
                    'Application\Repository' => 'default_driver',
                ],
            ],
        ],
    ],
];

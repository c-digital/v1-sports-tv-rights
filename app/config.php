<?php

return [
    // General.
    'application_name' => 'Sports TV Rights',
    'version' => '1.0.0',

    // Region.
    'language' => 'es',
    'timezone' => 'UTC',
    'charset' => 'utf-8',

    // Environment.
    'environment' => 'development',
    'errors' => true,
    'maintenance' => false,

    // Database.
    'database' => [
        [
            'name' => 'default',
            'driver' => 'mysql',
            'host' => 'localhost',
            'username' => 'sporttvbol_database',
            'password' => 'AM.P-v_$V~~*',
            'database' => 'sporttvbol_database',
            'port' => '3306',
        ],
    ],

    // Emails in localhost.
    'smtp' => [
        'host' => '',
        'username' => '',
        'password' => '',
        'port' => '',
    ],
];

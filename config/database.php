<?php

use Illuminate\Support\Str;

return [
   'default' => 'mysql',
   'connections' => [
      'mysql' => [
         'driver' => 'mysql',
         'host' => env('DB_HOST'),
         'sticky' => true,
         'port' => env('DB_PORT'),
         'database' => env('DB_DATABASE'),
         'username' => env('DB_USERNAME'),
         'password' => env('DB_PASSWORD'),
         'unix_socket' => '',
         'charset' => 'utf8',
         'collation' => 'utf8_unicode_ci',
         'options' => [PDO::ATTR_EMULATE_PREPARES => true],
         'prefix' => '',
         'strict' => false,
         'engine' => null,
      ],
      'staff' => [
         'driver' => 'mysql',
         'host' => env('DB_HOST'),
         'sticky' => true,
         'port' => env('DB_PORT'),
         'database' => env('DB_DATABASE'),
         'username' => env('DB_USERNAME'),
         'password' => env('DB_PASSWORD'),
         'unix_socket' => '',
         'charset' => 'utf8',
         'collation' => 'utf8_unicode_ci',
         'options' => [PDO::ATTR_EMULATE_PREPARES => true],
         'prefix' => '',
         'strict' => false,
         'engine' => null,
      ],
   ],
   'migrations' => 'migrations',
   'redis' => [
      'client' => 'predis',
      'default' => [
         'host' => '',
         'password' => null,
         'port' => 6379,
         'database' => 0,
      ],
   ],
];

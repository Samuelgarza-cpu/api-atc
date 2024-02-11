## About

Proyecto Escolar

php artisan migrate:fresh --path=database/migrations/GomezApp --database=mysql_gomezapp
php artisan db:seed --class=DatabaseGomezAppSeeder

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## MySql

SET sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

## Config

database.php -> 'strict' => false,


APP_ENV=production
APP_URL=https://backend.atc.gomezpalacio.gob.mx
FILESYSTEM_DISK=public

EN filesystems.php

 'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/public',
            'visibility' => 'public',
            'throw' => false,
        ],

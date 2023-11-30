## About

Proyecto Escolar SAMUEL GARZA

php artisan migrate:fresh --path=database/migrations/GomezApp --database=mysql_gomezapp
php artisan db:seed --class=DatabaseGomezAppSeeder

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## MySql

SET sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

## Config

database.php -> 'strict' => false,

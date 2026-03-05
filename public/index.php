<?php
// import tried
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
// konstanta s casom zaciatku aplikacie (pre meranie casu spracovania requestu)
define('LARAVEL_START', microtime(true));

// Je aplikacia v maintenance? 
// php artisan down, php artisan up
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

//tuto composer zabezpeci ze laravel vie najst svoje triedy (autoloading tried)
require __DIR__.'/../vendor/autoload.php';

 
/** @var Application $app */

// Vytvori sa instancia Application 
$app = require_once __DIR__.'/../bootstrap/app.php';

// zivotny cyklus Requestu 
// Request ide do HTTP Kernel, prejde middleware, 
// najde route, zavola Controller, vrati response
$app->handleRequest(Request::capture());

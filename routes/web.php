<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/backup-file', function()
{
    $fileName = env("DB_DATABASE")."_". Carbon::now()->getTimestamp(). ".sql";

    try
    {
        Artisan::call("database:backup", [ "fileName"=>$fileName ]);
    }
    catch(Exception $e)
    {
        echo "Message: " .$e->getMessage();
    }

    $pathToFile = storage_path()."//backup/".$fileName;

    $headers = [
        'Content-Description' => 'File Transfer',
        'Content-Type' => 'application/sql'
    ];

    // Artisan::call("database:backup");

    return response()->download($pathToFile, $fileName, $headers);
});

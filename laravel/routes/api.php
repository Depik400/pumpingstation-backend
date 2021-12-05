<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [Controllers\API\AuthController::class,'register']);
Route::post('/login', [Controllers\API\AuthController::class,'login'])->name('login');
Route::get('/testtoken',[Controllers\API\AuthController::class,'checkToken']);


Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [Controllers\API\AuthController::class,'logout']);

    //Управление ценами
    Route::get('/getPrice',[Controllers\PriceOfStationController::class,'index']);
    Route::get('/getCurrentPricePair',[Controllers\PriceOfStationController::class,'getCurrentPricePair']);
    Route::post('/updateCurrentPricePair',[Controllers\PriceOfStationController::class,'updateCurrentPricePair']);
    //Управление резидентами
    Route::get("/allResidents",[Controllers\ResidentsController::class,'index']);
    Route::post('/addResident',[Controllers\ResidentsController::class,'addNewResident']);
    Route::post('/updateSelectedResident',[Controllers\ResidentsController::class,'updateResident']);
    Route::get('/residentsPumpMeter',[Controllers\BillsController::class,'getUserWithoutBill']);
    Route::get('/residents',[Controllers\ResidentsController::class,'getResindentOfStation']);
    Route::get('/residentsWithBills',[Controllers\BillsController::class,'index']);
    //Управление периодами
    Route::post('/addPeriod',[Controllers\PeriodsController::class,'addPeriod']);
    Route::get('/periods',[Controllers\PeriodsController::class,'index']);
    //Управление записями
    Route::post('/addPumpRecord',[Controllers\PumpMeterRecordsController::class,'addNewPumpMeterRecord']);
});



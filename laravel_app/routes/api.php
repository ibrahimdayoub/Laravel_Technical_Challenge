<?php
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\API\SubunitController;
use App\Http\Controllers\API\ProductController;

use Illuminate\Support\Facades\Route;


//Unit
Route::post('units',[UnitController::class,'setUnit']);

// if you need..
/*
    Route::get('units',[UnitController::class,'getUnits']);
    Route::delete('units/{id}',[UnitController::class,'removeUnit']);
    Route::get('units/{id}',[UnitController::class,'getUnit']);
    Route::put('units/{id}',[UnitController::class,'updateUnit']);
    Route::get('units/{id}/subunits',[UnitController::class,'getUnitSubunits']);
*/

//Subunit
Route::post('subunits',[SubunitController::class,'setSubunit']);

// if you need..
/*
    Route::get('subunits',[SubunitController::class,'getSubunits']);
    Route::delete('subunits/{id}',[SubunitController::class,'removeSubunit']);
    Route::get('subunits/{id}',[SubunitController::class,'getSubunit']);
    Route::put('subunits/{id}',[SubunitController::class,'updateSubunit']);
    Route::get('subunits/{id}/unit',[SubunitController::class,'getSubunitUnit']);
*/


//products
Route::get('products',[ProductController::class,'getProducts']);
Route::post('products',[ProductController::class,'setProduct']);

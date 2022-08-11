<?php

use App\Http\Controllers\Api\V1\SalesCompanyApiController;
use App\Http\Controllers\Api\V1\CountryApiController;
use App\Http\Controllers\Api\V1\LanguageApiController;

Route::group(['namespace' => 'V1'], function () {

	//Last company id API route
	Route::get('/last-company-id', [SalesCompanyApiController::class, 'lastCompanyId']);
	Route::post('/sales-company-store', [SalesCompanyApiController::class, 'store']);

	// Country List API route
	Route::get('/country-list', [CountryApiController::class, 'getCountryList']);
	
	// Country List API route
	Route::get('/language-list', [LanguageApiController::class, 'getLanguageList']);


});

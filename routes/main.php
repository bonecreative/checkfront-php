<?php
Route::group(['as' => 'checkfront::', 'prefix' => 'public-api', 'namespace' => '\\BoneCreative\\CheckFront\\Controllers', 'middleware' => ['cors', 'api', 'checkfront']], function ()
{

	Route::group(['as' => 'calendar::', 'prefix' => 'calendar'], function ()
	{
		Route::get('dates', [
			'as'   => 'dates',
			'uses' => 'CalendarController@index',
		]);


		Route::group(['prefix' => 'dates/{date}'], function ()
		{
			Route::get('', [
				'as'   => 'date',
				'uses' => 'CalendarController@show',
			]);

			Route::get('{details}', [
				'as'   => 'details',
				'uses' => 'DetailController',
			]);
		});
	});

	Route::options('{any}');
	Route::resource('bookings', 'BookingController', ['only' => ['create', 'store']]);
	Route::resource('discounts', 'DiscountController', ['only' => ['show']]);
	Route::resource('addons', 'AddonController', ['only' => ['index']]);


	Route::group(['as' => 'ancillary::', 'prefix' => 'ancillary'], function ()
	{

		Route::get('regions', [
			'as'   => 'regions',
			'uses' => 'AncillaryController@regions',
		]);

		Route::get('fee', [
			'as'   => 'fee',
			'uses' => 'AncillaryController@fee',
		]);
        
        Route::get('exchange-rates', [
            'as'   => 'exchange-rates',
            'uses' => 'AncillaryController@exchangeRates',
        ]);
        
        Route::get('currencies/{currency}/symbol', [
            'as'   => 'currency-symbol',
            'uses' => 'AncillaryController@currencySymbol',
        ]);

	});
});
<?php

Route::group(['as' => 'orm::', 'prefix' => 'orm', 'namespace' => '\\BoneCreative\\CheckFront\\Controllers', 'middleware' => ['web', 'auth']], function (){

	FuquIo\LaravelPrototypeUi\Helpers::ResourceGridRouting('check-front-accounts', ['index', 'edit', 'update', 'store'], ['index', 'update', 'destroy']);
	Route::group(['prefix' => 'check-front-accounts/{check_front_account}'], function (){
		FuquIo\LaravelPrototypeUi\Helpers::ResourceGridRouting('check-front-sites', ['index', 'edit', 'update', 'store'], ['index', 'update', 'destroy'],null,['','grid']);
	});

	//@cursor>>

});

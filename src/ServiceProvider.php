<?php

namespace BoneCreative\CheckFront;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider
 * @package BoneCreative\LaravelCors
 */
class ServiceProvider extends BaseServiceProvider
{
	const VENDOR_PATH = 'bonecreative/checkfront-php';
	const SHORT_NAME = 'checkfront';
	
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->bootCommands();
	}
	
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
	}
	
	private function bootCommands()
	{
		$this->commands([CacheCouponsCommand::class]);
	}
	
	
}
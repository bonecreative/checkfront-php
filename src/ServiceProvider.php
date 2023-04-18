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
		$this->bootRoutes();
		$this->bootMigrations();
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
	
	/**
	 * @internal
	 */
	private function bootRoutes()
	{
		$this->loadRoutesFrom(__DIR__ . '/../routes/main.php');
		$this->loadRoutesFrom(__DIR__ . '/../routes/grids.php');
	}
	
	/**
	 * @internal
	 */
	private function bootMigrations(){
		$this->loadMigrationsFrom(__DIR__ . '/../migrations');
	}
	
}
<?php namespace vendocrat\Settings;

use Illuminate\Support\ServiceProvider;
use vendocrat\Settings\Driver\Driver;

class SettingsServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->setupConfig();
	}

	/**
	 * Setup the config.
	 *
	 * @return void
	 */
	protected function setupConfig()
	{
		$source = realpath(__DIR__.'/../config/config.php');

		if ( class_exists('Illuminate\Foundation\Application', false) ) {
			$this->publishes([
				$source => config_path('settings.php')
			]);
		}

		$this->mergeConfigFrom($source, 'settings');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton(SettingsManager::class, function ($app) {
			return new SettingsManager($app);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return string[]
	 */
	public function provides()
	{
		return [
			SettingsManager::class,
			Driver::class
		];
	}
}

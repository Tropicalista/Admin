<?php 

namespace Tropicalista\Admin;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Tropicalista\Admin\Models\Setting;
use View;
use App;
use Cache;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router) {

        $this->handleViews();
        $this->handleTranslations();
        $this->handleMigrations();
        $this->handleRoutes();
        $this->app['router']->aliasMiddleware('role', 'Tropicalista\Admin\Middleware\RoleMiddleware');

        if(file_exists(storage_path('installed'))){
            App::singleton('site_settings', function(){
                $site_settings = Cache::remember('settings', 60, function() {
                    return Setting::all();
                });
                return $site_settings;
            });
            // If you use this line of code then it'll be available in any view
            // as $site_settings but you may also use app('site_settings') as well
            View::share('site_settings', app('site_settings'));     
        }

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        // Bind any implementations.

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {

        return [];
    }

    private function handleTranslations() {

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'admin');
    }

    private function handleViews() {

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'admin');

        $this->publishes([__DIR__.'/../resources/views' => base_path('resources/views/vendor/admin')]);
    }

    private function handleMigrations() {

        $this->publishes([__DIR__ . '/../migrations' => base_path('database/migrations')]);
    }

    private function handleRoutes() {

        $this->loadRoutesFrom(__DIR__.'/../routes.php');
        //include __DIR__.'/../routes.php';
    }

    /**
     * Register scaffolding command
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\MakeAdmin::class,
            ]);
        }
    }

}

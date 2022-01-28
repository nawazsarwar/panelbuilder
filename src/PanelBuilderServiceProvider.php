<?php

namespace NawazSarwar\PanelBuilder;

use NawazSarwar\PanelBuilder\Commands\PanelBuilderInstall;
// use NawazSarwar\PanelBuilder\Commands\PanelBuilderConfig;
use Illuminate\Support\ServiceProvider;

class PanelBuilderServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register vendor translations
        $this->loadTranslationsFrom( base_path('resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'laraveldaily' . DIRECTORY_SEPARATOR), 'panelbuilder');
        // Register vendor views
        $this->loadViewsFrom(__DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'pb', 'pb');
        $this->loadViewsFrom(__DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'templates', 'tpl');
        /* Publish master templates */
        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'panelbuilder.php'                                                => config_path('panelbuilder.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'admin'                                                            => base_path('resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'auth'                                                             => base_path('resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'auth'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'emails'                                                           => base_path('resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'emails'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Translations'                                                                                     => base_path('resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'laraveldaily'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Public' . DIRECTORY_SEPARATOR . 'panelbuilder'                                                    => base_path('public' . DIRECTORY_SEPARATOR . 'panelbuilder'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'UsersController'          => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'UsersController.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'RolesController'          => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'RolesController.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'Controller'               => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Controller.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'FileUploadTrait'          => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Traits' . DIRECTORY_SEPARATOR . 'FileUploadTrait.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'ForgotPasswordController' => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Auth' . DIRECTORY_SEPARATOR . 'ForgotPasswordController.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'LoginController'          => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Auth' . DIRECTORY_SEPARATOR . 'LoginController.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'RegisterController'       => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Auth' . DIRECTORY_SEPARATOR . 'RegisterController.php'),
            __DIR__ . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'ResetPasswordController'  => app_path('Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Auth' . DIRECTORY_SEPARATOR . 'ResetPasswordController.php'),
            // __DIR__ . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'publish' . DIRECTORY_SEPARATOR . 'Role'                          => app_path('Models\Role.php'),
        ], 'panelbuilder');

        // Register commands
        $this->app->bind('panelbuilder:install', function ($app) {
            return new PanelBuilderInstall();
        });
        $this->commands([
            'panelbuilder:install'
        ]);
        // Routing
        include __DIR__ . DIRECTORY_SEPARATOR . 'routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Register main classes
        $this->app->make('NawazSarwar\PanelBuilder\Controllers\PanelBuilderController');
        $this->app->make('NawazSarwar\PanelBuilder\Controllers\UserActionsController');
        $this->app->make('NawazSarwar\PanelBuilder\Controllers\PanelBuilderMenuController');
        $this->app->make('NawazSarwar\PanelBuilder\Cache\QuickCache');
        $this->app->make('NawazSarwar\PanelBuilder\Builders\MigrationBuilder');
        $this->app->make('NawazSarwar\PanelBuilder\Builders\ModelBuilder');
        $this->app->make('NawazSarwar\PanelBuilder\Builders\RequestBuilder');
        $this->app->make('NawazSarwar\PanelBuilder\Builders\ControllerBuilder');
        $this->app->make('NawazSarwar\PanelBuilder\Builders\ViewsBuilder');
        $this->app->make('NawazSarwar\PanelBuilder\Events\UserLoginEvents');
        // Register dependency packages
        $this->app->register('Collective\Html\HtmlServiceProvider');
        $this->app->register('Intervention\Image\ImageServiceProvider');
        $this->app->register('Yajra\Datatables\DatatablesServiceProvider');
        // Register dependancy aliases
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('HTML', 'Collective\Html\HtmlFacade');
        $loader->alias('Form', 'Collective\Html\FormFacade');
        $loader->alias('Image', 'Intervention\Image\Facades\Image');
        $loader->alias('Datatables', 'Yajra\Datatables\Datatables');
    }

}

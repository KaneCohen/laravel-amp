<?php
namespace Cohensive\Amp;

use Illuminate\Support\ServiceProvider;

class AmpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'amp');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/amp.php' => $this->app->configPath('amp.php'),
            ], 'config');


            $this->publishes([
                __DIR__.'/../resources/views' => $this->app->basePath('resources/views/vendor/amp'),
            ], 'views');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/amp.php', 'amp');

        $this->app->singleton('amprouter', AmpRouter::class);

        $this->registerAmpViewFactory();
        $this->registerAmpViewComposer();
    }

    private function registerAmpViewFactory()
    {
        $this->app->singleton('view', function ($app) {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $app['view.engine.resolver'];

            $finder = $app['view.finder'];

            $env = new AmpViewFactory(
                $resolver,
                $finder,
                $app['events'],
                $app['config']->get('amp.view_affix'),
                $app['config']->get('amp.view_bool_name'),
                $app['config']->get('amp.view_fallback')
            );

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $env->setContainer($app);

            $env->share('app', $app);

            return $env;
        });
    }

    private function registerAmpViewComposer()
    {
        $this->app['view']->composer(
            $this->app['config']->get('amp.layouts', []),
            AmpMatchComposer::class
        );
    }
}

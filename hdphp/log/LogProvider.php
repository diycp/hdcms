<?php namespace hdphp\log;

use hdphp\kernel\ServiceProvider;

class LogProvider extends ServiceProvider
{

    //延迟加载
    public $defer = false;

    public function boot ()
    {

    }

    public function register ()
    {
        $this->app->single (
            'Log',
            function ($app)
            {
                return new Log($app);
            },
            true
        );
    }
}
<?php namespace hdphp\rbac;

use hdphp\kernel\ServiceProvider;

class RbacProvider extends ServiceProvider
{

    //延迟加载
    public $defer = true;

    public function boot ()
    {
    }

    public function register ()
    {
        $this->app->single (
            'Rbac',
            function ()
            {
                return new Rbac();
            }
        );
    }
}
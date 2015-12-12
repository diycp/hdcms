<?php namespace hdphp\kernel;

use Exception;
use ReflectionMethod;

require ROOT_PATH.'/system/routes.php';

class Kernel
{
    public function __construct ($app)
    {
        //设置字符集
        header ("Content-type:text/html;charset=".Config::get ('app.charset'));

        //时区
        date_default_timezone_set (Config::get ('app.timezone'));

        //路由处理
        Route::dispatch ();

        //导入钓子
        $app['Hook']->import (Config::get ('hook'));

        //应用开始钓子
        $app['Hook']->listen ("app_begin");

        //定义常量
        $this->DefineConsts ();

        //执行控制器方法
        $this->ExecuteAction ();

        //应用结束钩子
        $app['Hook']->listen ("app_end");

        //保存日志
        Log::save ();
    }

    /**
     * 定义常量
     */
    private function DefineConsts ()
    {
        //模块目录
        defined ('MODULE_PATH') or define ('MODULE_PATH', APP_PATH.'/'.MODULE);
        //模板目录
        defined ('VIEW_PATH') or define ('VIEW_PATH', defined ('MODULE_PATH') ? MODULE_PATH.'/View' : C ('view.path'));
        //公共目录
        defined ("__PUBLIC__") or define ('__PUBLIC__', __ROOT__.'/Public');
        //模板url
        defined ("__VIEW__") or define ('__VIEW__', __ROOT__.'/'.rtrim (VIEW_PATH, '/'));
    }

    //执行动作
    private function ExecuteAction ()
    {
        //禁止使用模块检测
        if (in_array (MODULE, C ('http.deny_module')))
        {
            throw new Exception(MODULE.'模块禁止使用');
        }
        $class = ucfirst (MODULE).'\\Controller\\'.ucfirst (CONTROLLER).'Controller';

        //控制器不存在
        if ( ! class_exists ($class))
        {
            throw new Exception("{$class} 不存在");
        }

        $controller = new $class;

        //执行动作
        try
        {
            $action = new ReflectionMethod($controller, ACTION);

            if ($action->isPublic ())
            {
                call_user_func_array (array($controller, ACTION), Route::getArg ());
            }
            else
            {
                throw new ReflectionException('动作不存在');
            }

        } catch (ReflectionException $e)
        {
            $action = new ReflectionMethod($controller, '__call');
            $action->invokeArgs ($controller, array(ACTION, ''));
        }
    }
}
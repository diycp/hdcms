<?php namespace system\service\menu;
use houdunwang\framework\build\Facade;

//外观构造类
class MenuFacade extends Facade{

	public static function getFacadeAccessor(){
		return 'Menu';
	}
}
<?php namespace system\service\module;
use houdunwang\framework\build\Facade;

//外观构造类
class ModuleFacade extends Facade{

	public static function getFacadeAccessor(){
		return 'Module';
	}
}
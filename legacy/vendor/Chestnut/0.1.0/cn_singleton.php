<?php

abstract class CN_Singleton
{
	private static $singleton_list = array();


	public function __construct($singleton)
	{
		if(is_object($singleton))
		{
			$class_name = get_class($singleton);

			if(isset(self::$singleton_list[$class_name]))
				throw new CN_Exception(sprintf(_("Class `%s` is allready instantiated."), $class_name));
			else
				self::$singleton_list[$class_name] = $singleton;
		}
		else
			throw new CN_Exception(sprintf(_("Bad argument type. Must be of type `object` and not `%s`."), gettype($singleton)));
	}


	protected function removeSingleton($class_name)
	{
		if(isset(self::$singleton_list[$class_name]))
			unset(self::$singleton_list[$class_name]);
	}


	public static function getSingleton()
	{
	    $class_name = func_get_arg(0);

		if(!isset(self::$singleton_list[$class_name]))
			self::$singleton_list[$class_name] = new $class_name;

		return self::$singleton_list[$class_name];
	}
}

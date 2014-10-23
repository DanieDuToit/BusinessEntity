<?php
/**
 * Created by PhpStorm.
 * User: dutoitd1
 * Date: 2014/10/22
 * Time: 03:29 PM
 */

class AutoLoader
{
	public static function BaseClassLoader($className)
	{
		$classFirstFourChars = substr($className, 0, 4);
		if ($classFirstFourChars == 'Base') {
			$path = 'Classes/BaseClasses/' . $className . '.class.php';
//			echo "loading $path";
			include $path;
		} else {
			$path = 'Classes/BaseClasses/' . $className . '.class.php';
//			echo "loading $path";
			include $path;
		}
	}
	public static function FunctionLoader()
	{
		include 'BaseClasses/functions.inc.php';
		include 'BaseClasses/settings.inc.php';
	}
} 
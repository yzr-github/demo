<?php
//类的加载（Spl注册自动加载）

function model_load($classname){
	if (!class_exists($classname)) {//判断该类名是否存在
		$classFile=$classname . '.php';//文件名
		//判断在当前文件夹是否存在
		if (file_exists($classFile)) {
			# 加载类
			include $classFile;
			// echo '已加载:' . $classname,'<hr>';
			return true;
		}	
	}
}


//把完成的自定义函数注册到spl_autoload_register()函数中
spl_autoload_register('model_load');


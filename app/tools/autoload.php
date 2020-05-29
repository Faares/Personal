<?php

spl_autoload_register(function ($class){
	$class = str_replace("\\","/",$class);
	$file = __DIR__.DIRECTORY_SEPARATOR.$class.".php";
	require_once $file;
});

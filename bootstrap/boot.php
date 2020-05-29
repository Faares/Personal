<?php
/**
 *
 * هذا الملف يُستدعى من قبل ملف index.php في المجلد الرئيسي , لذلك كل المسارات paths تكون بالنسبة للمجلد الرئيسي .
 *
 * @since  0.2
 * */

/* to calculate the speed of the software. */
define("START",microtime(true));




/* set timezone. */
date_default_timezone_set('Asia/Riyadh');


/* load all classes. */
require "app/tools/autoload.php";


/* get configuration filee. */
$Configs = require "configs.php";


# define all Configs
foreach ($Configs as $k => $v) {
	if(substr($k,0,3) == "DIR")
		$v = $v.DIRECTORY_SEPARATOR;
	define($k,$v);
}

if(DEBUG_MODE){
	ini_set("display_errors", "1");
	error_reporting(E_ALL);
}else{
	error_reporting(0);
}

require DIR_APP."router.php";

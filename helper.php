<?php

	/**
	 * "Spews" out header code from header.php file
	 * @param $arr An array which holds such information as page title, css files etc..
	 * @param $file Name of file from which code should be spued from
	 */
	function createTemplate($arr = array(), $file){
		extract($arr); // takes array and creates global variables out of array data. Variable name: array key, Variable value: corresponding array value
		require($file . '.php'); // "spits" out the code found in 'header.php'. Has access to global variables created from extract($arr)
	}

?>
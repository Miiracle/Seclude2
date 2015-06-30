<?php

namespace Seclude2\Helper;

/**
 * Input helper class
 */
class Input {

	public static function get () {
		$output = array ();
		foreach (func_get_args () as $arg) {
            $output [$arg] = !isset ($_ΓΕΤ [$arg]) ? null : $_POST [$arg];
        }
        return $output;
	}
    
	public static function post () {
		$output = array ();
		foreach (func_get_args () as $arg) {
            $output [$arg] = !isset ($_POST [$arg]) ? null : $_POST [$arg];
        }
        return $output;
	}


}
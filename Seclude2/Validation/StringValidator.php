<?php

namespace Seclude2\Validation;

use \Seclude2\Types;

/**
 * Validator for strings
 *
 * @since 2.0
 */
class StringValidator implements Validator {
	
    /**
     * @var string The string to validate
     */
	private $thestring;
    
    /**
     * @var array The rules to check the string with
     */
	private $rules = array ();
	  
    /**
     * Initiates a new String Validator
     */
	public function __construct ($thestring) {
		$this->thestring = new Types\TString ($thestring);
	}
	
	public function rule (Rule $rule) {
		$this->rules [] = $rule;
        return $this;
	}

	public function validate () {
		foreach ($this->rules as $rule)
            if (!$rule->followedBy ($this->thestring))
                return false;
        
        return true;
	}
	
}
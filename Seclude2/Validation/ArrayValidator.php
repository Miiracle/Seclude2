<?php

namespace Seclude2\Validation;

class ArrayValidator {

    /**
     * @var $thearray array The array to validate
     */
	private $thearray;
    
    /**
     * Initiates a new Array Validator
     * 
     * @param $thearray array The array
     */
    public function __construct (array $thearray) {
        $this->thearray = $thearray;
    }
    
    public function rule (Rule $rule) {
        
    }
    
	public function validate ($value) {
	
	}

}
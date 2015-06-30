<?php

namespace Seclude2\Validation;

use Seclude2\Types;

/**
 * Rule that checks whether the length of a string
 * is within a certain range.
 *
 * @since 2.0
 */
class StringLengthRangeRule implements Rule {
	
    /**
     * @var $min int The minimum string length
     * @var $max int The maximum string length
     */
	private $min = null, $max = null;
    
    /**
     * Sets the minimum string length
     *
     * @pararm $min int The minimum length
     * @return $this
     */
	public function min ($min) {
		$this->min = $min;
        return $this;
	}
    
    /**
     * Sets the maximum string length
     *
     * @param $max int The maximum length
     * @return $this
     */
    public function max ($max) {
        $this->max = $max;
        return $this;
    }
	
    /**
     * Checks whether this rule is followed by the $validatable
     *
     * @param $validatable Validatable A validatable element
     * @return bool True if it follows the rules, else false
     * @throws ValidationException When a non-string is passed
     */
	public function followedBy (Validatable $validatable) {
        if (!$validatable instanceof Types\TString) {
            if (is_string ($validatable))
                $validatable = new Types\TString ($validatable);
            else
                throw new ValidationException ('Cannot validate a non-string through a String Rule');
        }
        
        $minOK = $this->min == null || $validatable->len () >= $this->min;
        $maxOK = $this->max == null || $validatable->len () <= $this->max;
        
        return $minOK && $maxOK;
    }
	
}
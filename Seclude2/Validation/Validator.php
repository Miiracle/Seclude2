<?php

namespace Seclude2\Validation;

/**
 * Validator interface
 */
interface Validator {
	
    /**
     * Adds a rule to the rule collection
     * 
     * @param $rule Seclude2\Validation\Rule The rule to check
     * @return $this
     */
    public function rule (Rule $rule);
    
    /**
     * Validates whether the given input follows all the rules from the collection
     *
     * @return bool True if the input follows all the rules, false if not.
     */
	public function validate ();
	
}
<?php

namespace Seclude2\Types;

use \Seclude2\Validation;

/**
 * A class representing an integer
 *
 * @since 2.0
 */
class TInteger implements Validation\Validatable {
    
    /**
     * @var $theint int The actual integer
     */
    private $theint;
    
    /**
     * Initiates a new TInteger instance
     *
     * @param $theint int The integer
     */
    public function __construct ($theint) {
        $this->theint = intval ($theint);
    }
    
    public function __toString () {
        return (string) $this->theint;
    }
    
    public function power ($to) {
        return new static(pow ($this->theint, $to));
    }
   
   public function root ($root) {
        return new static (pow ($this->theint, 1 / $root));
    }
    
}

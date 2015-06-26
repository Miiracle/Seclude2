<?php

namespace Seclude2\Types;

class TInteger {
    
    private $theint;
    
    public function __construct ($theint) {
        $this->theint = intval ($theint);
    }
    
    public function __toString () {
        return $this->theint;
    }
    
}

<?php

namespace Seclude2\Routing;

class Route {

    private $pattern;
    private $destination;
    private $match = array ();
    
    public function __construct ($pattern, Destination $destination) {
        $this->pattern = $pattern;
        $this->destination = $destination;
    }
    
    /**
     * Check whether the given request matches the pattern
     */
    public function matches ($request) {
        return preg_match ($this->pattern, $request, $this->match);
    }
    
    public function getDestination () {
        return $this->destination->apply (
    }
    
}

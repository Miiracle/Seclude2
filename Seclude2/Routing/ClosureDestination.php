<?php

namespace Seclude2\Routing;

/**
 * Destination that, upon run, executes a
 * function with the given arguments.
 */
class ClosureDestination implements Destination {
    
    /**
     * The function to be executed upon Run
     * @var Closure
     */
    private $destination;
    
    /**
     * Initiates a closure destination
     *
     * @param $destination Closure The function
     */
    public function __construct (Closure $destination) {
        $this->destination = $destination;
    }
    
    public function run (array $parameters) {
        call_user_func_array ($this->destination, $parameters);
    }
    
}
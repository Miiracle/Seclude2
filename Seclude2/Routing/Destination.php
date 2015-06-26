<?php

namespace Seclude2\Routing;

/**
 * Route Destination
 * 
 * @since 2.0
 */
interface Destination {
    
    /**
     * Runs the route destination
     * 
     * @param $parameters array
     *      The parameters from the Request URL
     */
    public function run (array $parameters);
    
}
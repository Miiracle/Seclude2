<?php

namespace Seclude2\Routing;

/**
 * Route Destination that redirects to another URL
 *
 * @since 2.0
 */
class RedirectDestination implements Destination {
	
    /**
     * @var $location string The URL to redirect to
     */
	private $location;
	
    /**
     * Initiate a new RedirectDestination instance.
     *
     * @param $location string
     *          The URL to redirect to.
     *          Can contain replacement parameters in the form of {n}
     */
	public function __construct ($location) {
		$this->location = $location;
	}
	
	public function run (array $parameters) {
		// Replace every {n} in the passed location by $parameter [n]
        $parsedLocation = preg_replace_callback ('/\{([0-9]+)\}/', function ($matches) use ($parameters) {
             if (!array_key_exists ($matches[1], $parameters))
                throw new DestinationException ('The given parameter index '. $matches [1] .' for the location is not present. Check the route pattern.');
            
            return $parameters [$matches [1]];
        }, $this->location);
        
        // Redirect using a HTTP header
        header ('Location: '. $parsedLocation);
        exit ();
	}
	
}
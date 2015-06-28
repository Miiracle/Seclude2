<?php

namespace Seclude2\Routing;
use Seclude2\Http\Request;

class Router
{
    
    /**
     * The route collections for the HTTP methods
     * 
     * @access private
     * @var array
     */
    private $routes = array (
        'GET' => array (),
        'POST' => array (),
        'PUT' => array (),
        'DELETE' => array (),
        'HEAD' => array (),
    );
    
    /**
     * Catch-all
     * @var Destination
     */
    private $all = null;
    
    /**
     * Initiates a Router
     *
     * @param $catchAll Seclude2\Routing\Destination The catch-all destination
     */
    public function __construct (Destination $catchAll)
    {
        $this->all = $catchAll;
    }
    
    /**
     * Adds a route to the collection
     *
     * @param $methods string|array Array or by | separated string with the methods this route counds for
     */
    public function route ($methods, $pattern, Destination $dest)
    {
        // Split by | if $methods is not yet an array
        if (!is_array ($methods))
            $methods = explode ('|', $methods);
        
        // Create a route
        $route = new Route ($pattern, $dest);
        
        // For each method specified, add $route
        foreach ($methods as $method) {
            $method = strtoupper ($method);
            
            // If the current method is not yet in the $routes array, add it
            if (!array_key_exists ($method, $this->routes))
                $this->routes [$method] = array();
            
            // Add the route to the method route collection
            $this->routes [$method][] = $route;
        }
        
        return $this;
    }
    
    /**
     * Execute the router
     *
     * @param $request Seclude2\Http\Request The request containing the request path etc
     */
    public function execute (Request $request)
    {
        // Check if there's any route collection for this HTTP method
        // If not, just jump to the Catch-all
        if (isset ($this->routes [$request->getMethod ()])) {
            // Loop over each route in the collection for this method
            foreach ($this->routes [$request->getMethod ()] as $route) {
                // Check if the request works for the route
                if ($route->matches ($request->getPath ())) {
                    // If so, run the destination and cancel the loop
                    $route->runDestination ();
                    return;
                }
            }
        } 
        
        // If the function ever gets here, there was no relevant route
        // The catch-all, say, the 404 destination, gets ran
        $this->all->run (array ());
    }
    
}


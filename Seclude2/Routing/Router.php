<?php

namespace Seclude2\Routing;
use Seclude2\Http\Request;

/**
 * HTTP fancy-url request router
 *
 * @since 2.0
 */
class Router
{
    
    /**
     * @var array The route collections for the HTTP methods
     */
    private $routes = array (
        'GET' => array (),
        'POST' => array (),
        'PUT' => array (),
        'DELETE' => array (),
        'HEAD' => array (),
    );
    
    /**
     * @var Destination Catch-all
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
     * @return $this
     */
    public function route ($methods, $pattern, Destination $dest)
    {
        // Create a route
        $route = new Route ($pattern, $dest);
        
        // Split by | if $methods is not yet an array
        if (!is_array ($methods))
            $methods = explode ('|', $methods);
        
        // If all the methods should be used,
        if (in_array  ('*', $methods)) {
            foreach ($this->routes as &$collection)
                $collection [] = $route;
        } else {
            // For each method specified, add $route
            foreach ($methods as $method) {
                $method = strtoupper ($method);
                
                // If the current method is not yet in the $routes array, add it
                // This should not be a common case.
                if (!array_key_exists ($method, $this->routes))
                    $this->routes [$method] = array();
                
                // Add the route to the method route collection
                $this->routes [$method][] = $route;
            }
        }
        
        return $this;
    }
    
    public function get ($pattern, Destination $dest) {
        $this->routes ['GET'] [] = new Route ($pattern, $dest);
    }
    public function post ($pattern, Destination $dest) {
        $this->routes ['POST'] [] = new Route ($pattern, $dest);
    }
    public function put ($pattern, Destination $dest) {
        $this->routes ['PUT'] [] = new Route ($pattern, $dest);
    }
    public function delete ($pattern, Destination $dest) {
        $this->routes ['DELETE'] [] = new Route ($pattern, $dest);
    }
    
    public function all ($pattern, Destination $dest) {
        $route = new Route ($pattern, $dest);
        foreach ($this->routes as &$collection)
            $collection [] = $route;
    }
    
    /**
     * List all the registered routers
     * 
     * @param $method Optional method parameter
     */
    public function getRoutes ($method = null) {
        if ($method == null)
            return $this->routes;
        else {
            $method = strtoupper ($method);
            
            if (isset ($this->routes [$method]))
                return $this->routes [$method];
            else
                return array ();
        }
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
                    // If so, try to run the destination and cancel the loop
                    try {
                        $route->runDestination ();
                        return;
                    }
                    // Sometimes errors show up. In that case, we want the catchall to be ran.
                    catch (DestinationException $destEx) {
                        break;
                    }
                }
            }
        } 
        
        // If the function ever gets here, there was no relevant route
        // The catch-all, say, the 404 destination, gets ran
        $this->all->run (array ());
    }
    
}


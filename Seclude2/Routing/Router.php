<?php

namespace Seclude2\Routing;
use Seclude2\Http\Request;

class Router {
    
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
    
    public function __construct (Destination $catchAll){
        $this->all = $catchAll;
    }
    
    public function get ($pattern, Destination $dest) {
        
    }
    
    public function execute (Request $request) {
        // Select the right 
        switch ($request->getMethod ()) {
            case 'GET': $methods &= $this->get; break;
            case 'POST': $methods &= $this->post; break;
            case 'PUT': $methods &= $this->put; break;
            case 'DELETE': $methods &= $this->delete; break;
        }
        if (isset ($methods)) {
            foreach ($methods as $method) {
                if ($method->matches ($request->getPath ())) {
                    
                }
            }
        } 
        
        $this->all->run (array ());
    }
    
}


    // /**
     // * Define the current relative URI
     // * @return string
     // */
    // protected function getCurrentUri()
    // {
        // // Get the current Request URI and remove rewrite basepath from it (= allows one to run the router in a subfolder)
        // $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        // $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
        // // Don't take query params into account on the URL
        // if (strstr($uri, '?')) {
            // $uri = substr($uri, 0, strpos($uri, '?'));
        // }
        // // Remove trailing slash + enforce a slash at the start
        // $uri = '/' . trim($uri, '/');
        // return $uri;
    // }
// }
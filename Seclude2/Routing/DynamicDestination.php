<?php

namespace Seclude2\Routing;

/**
 * Destination that, upon run, executes a
 * function with the given arguments.
 */
class DynamicDestination implements Destination
{
    
    /**
     * @var callable Useful default callable to explode on /
     */
    public static $slashSplit;
    
    /**
     * @var callable Useful default callable to not parse arguments at all
     */
    public static $noParse;
    
    /**
     * @var string The cpath of the class@method(args) of the destination
     */
    private $cpath;
    
    /**
     * @var int The parameter number of the class
     */
    private $clazz;
    
    /**
     * @var int The parameter number of the method
     */
    private $method;
    
    /**
     * @var int The parameter number of the arguments
     */
    private $args;
    
    /**
     * @var callable The function to extract the arguments from a string
     */
    private $argsExtractor;
    
    /**
     * @var bool If true, static function calls are made to the class 
     */
    private $staticMethods;
    
    /**
     * Initiates a dynamic destination
     *
     * @param $cpath The class>method-path in this format: Namespace\Class@method:args (can take parameters like {1})
     * @param $argsExtractor callable A function which generates an array out of a string of arguments. How, that's up to the implementation
     * @param $staticMethods bool Whether to use static functions or not
     */
    public function __construct ($cpath, callable $argsExtractor, $staticMethods = false)
    {
        // Convert the cpath into an array
        $parts = explode ('@', $cpath);
        if (count ($parts) == 2)
            $parts2 = explode (':', $parts [1]);
            
        if (!isset ($parts2 [1]))
            throw new DestinationException ('The given cpath <code>'. $cpath .'</code> is not valid.');
        
        $this->clazz = $parts [0];
        $this->method = $parts2 [0];
        $this->args = $parts2 [1];
        $this->argsExtractor = $argsExtractor;
        $this->staticMethods = $staticMethods;
    }
    
    public function run (array $parameters)
    {
        // Make sure all the parameters and stuff are in the right place
        $className = preg_replace_callback ('/\{([0-9]+)\}/', function ($matches) use ($parameters) {
            if (!array_key_exists ($matches[1], $parameters))
                throw new DestinationException ('The given parameter index '. $matches [1] .' for the class is not present. Check the route pattern.');
            
            return $parameters [$matches [1]];
        }, $this->clazz);
        
        $methodName = preg_replace_callback ('/\{([0-9]+)\}/', function ($matches) use ($parameters) {
            if (!array_key_exists ($matches[1], $parameters))
                throw new DestinationException ('The given parameter index '. $matches [1] .' for the method is not present. Check the route pattern.');
            
            return $parameters [$matches [1]];
        }, $this->method);
        
        $args = preg_replace_callback ('/\{([0-9]+)\}/', function ($matches) use ($parameters) {
            if (!array_key_exists ($matches[1], $parameters))
                throw new DestinationException ('The given parameter index '. $matches [1] .' for the arguments is not present. Check the route pattern.');
            
            return $parameters [$matches [1]];
        }, $this->args);
        
        // Make sure the class exists
        if (!class_exists ($className))
            throw new DestinationException ('The given class name does not exist');
        
        // Initiate a new instance of that class if $staticMethods == false
        if ($this->staticMethods == false)
            $clazz = new $className;
        else
            $clazz = $className;
        
        // Check if the given class really contains the method
        if (!method_exists ($clazz, $methodName))
            throw new DestinationException ('The given method name does not exist');
        
        // Get the arguments to pass to the function
        // First load $this->argsExtractor and then execute it. PHP is weird.
        $extractor = $this->argsExtractor;
        $arguments = (array) $extractor ($args);
        
        // Call the class->method with $arguments
        call_user_func_array (array ($clazz, $methodName), $arguments);
    }

}

DynamicDestination::$slashSplit = function ($args) { return explode ('/', $args); };
DynamicDestination::$noParse = function () { return array (); };
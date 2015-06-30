<?php

namespace Seclude2
{
    if (!defined ('Seclude2\LIB_DIR')) {
        trigger_error ('There is no library path defined. Using default /vendor.');
        define ('Seclude2\LIB_DIR', realpath (__DIR__ .DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'));
    }
 
    if (!defined ('Seclude2\APP_DIR')) {
        trigger_error ('There is no application path defined. Using default /app.');
        define ('Seclude2\APP_DIR', realpath (__DIR__ .DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app'));
    }
    
    if (!defined ('Seclude2\APP_NS')) {
        trigger_error ('There is no application namespace defined. Using default \.');
        define ('Seclude2\APP_NS', '\\');
    }
    
    define ('Seclude2\APP_NS_LEN', strlen (APP_NS));

    spl_autoload_register(function ($className) {
        // Normalizer function, replacecs / and \ with DIRECTORY_SEPARATOR
        $normalize = function ($path) { return str_replace(array ('\\','/'), DIRECTORY_SEPARATOR, $path); };
        $cnLength = strlen ($className);
        
        // Seclude2 classes are loaded form __DIR__
        if ($cnLength >= 9 && substr ($className, 0, 9) == 'Seclude2\\')
            $fn = __DIR__ . DIRECTORY_SEPARATOR . $normalize(substr ($className, 9).'.php');
        
        // The user classes are loaded from the APP_DIR
        elseif ($cnLength >= APP_NS_LEN && substr ($className, 0, APP_NS_LEN) == APP_NS)
            $fn = APP_DIR . DIRECTORY_SEPARATOR . $normalize (substr ($className, APP_NS_LEN).'.php');
        
        // All the other things are loaded from the LIB_DIR
        else
            $fn = LIB_DIR . DIRECTORY_SEPARATOR . $normalize($className.'.php');
        
        // If the file is not a directory nor a link and is readable
        if (is_file($fn) && is_readable($fn))
            include_once $fn;
    });
}

namespace
{
    // Register some typing functions
    function str ($thestring)
    {
        return new \Seclude2\Types\TString ($thestring);
    }
    
    function int ($theint)
    {
        return new \Seclude2\Types\TInteger ($theint);
    }
    
    function html ($tagName, $closeTag = true) {
        return new \Seclude2\Helper\HtmlElement ($tagName, $closeTag);
    }
}
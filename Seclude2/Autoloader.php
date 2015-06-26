<?php

namespace Seclude2;

if (!defined ('Seclude2\LIB_DIR')) {
    trigger_error ('There is no library path defined. Using default /vendor.');
    define ('Seclude2\LIB_DIR', realpath (__DIR__ .DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'));
}

spl_autoload_register(function ($className) {
    // Normalizer function, replacecs / and \ with DIRECTORY_SEPARATOR
    $normalize = function ($path) { return str_replace(array ('\\','/'), DIRECTORY_SEPARATOR, $path); };
    
    // Seclude2 classes are loaded form __DIR__
    if (strlen($className) >= 9 && substr ($className, 0, 9) == 'Seclude2\\')
        $fn = __DIR__ . DIRECTORY_SEPARATOR . $normalize(substr ($className, 9).'.php');
    
    // All the other things are loaded from the to-be-defined LIB_DIR
    else
        $fn = LIB_DIR . DIRECTORY_SEPARATOR . $normalize($className.'.php');
    
    // If the file is not a directory nor a link and is readable
    if (is_file($fn) && is_readable($fn))
        include_once $fn;
});
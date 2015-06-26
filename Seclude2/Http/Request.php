<?php

namespace Seclude2\Http;

class Request {
    
    private $method;
    private $path;
    private $secure;
    
    public function __construct ($method, $path, $secure) {
        $this->method = $method;
        $this->path  = $path;
        $this->secure = $secure;
    }
    
    public static function fromGlobals () {
        return new Request ($_SERVER['REQUEST_METHOD'], $_SERVER ['PHP_SELF'], isset ($_SERVER['HTTPS']));
    }
    
    public function getMethod () {
        return $this->method;
    }
    
    public function getPath () {
        return $this->path;
    }
    
    public function isSecure () {
        return $this->secure;
    }
    
}
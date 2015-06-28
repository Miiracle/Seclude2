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
        return new Request ($_SERVER['REQUEST_METHOD'], self::detectRequestPath($_SERVER ['REQUEST_URI'], $_SERVER ['SCRIPT_NAME']), isset ($_SERVER['HTTPS']));
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
    
    public static function detectRequestPath ($requestURI, $scriptName) {
        $pos = strpos ($_SERVER ['REQUEST_URI'], '?');
        return '/'. trim (substr ($pos !== FALSE ? substr ($_SERVER ['REQUEST_URI'], 0, $pos) : $_SERVER ['REQUEST_URI'], strlen (implode ('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']),0,-1)).'/')), '/');
    }
    
}
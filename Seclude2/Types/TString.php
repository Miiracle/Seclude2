<?php

namespace Seclude2\Types;

class TString {
    
    private $thestring;
    private $length;
    
    public function __construct ($thestring) {
        $this->thestring = $thestring;
        $this->length = strlen ($thestring);
    }
    
    public function __toString () {
        return $this->thestring;
    }
    
    public function len () {
        return $this->length;
    }
    
    function startsWith($needle) {
        return $needle === '' || strrpos($this->thestring, $needle, - $this->length) !== FALSE;
    }
    
    function endsWith($needle) {
        return $needle === '' || (($temp = $this->length - strlen($needle)) >= 0 && strpos($this->thelength, $needle, $temp) !== FALSE);
    }
    
    public static function mid($s, $e) {
        $p1 = strpos($this->thestring, $s);
        $p2 = strrpos($this->thestring, $e);
        return $p1 === false ? '' : $p2 == false ? substr($this->thestring, $p1) : substr($this->thestring, $p1 + 1, $p2 - $p1 - 1);
    }
    
    public static function fromFirst($c, $this->thestring) {
        $p = strpos($this->thestring, $c);
        return $p === false ? '' : substr($this->thestring, $p + 1);
    }
    
    public static function untilFirst($c, $this->thestring) {
        $p = strpos($this->thestring, $c);
        return $p === false ? $this->thestring : substr($this->thestring, 0, $p);
    }
    
    public static function fromLast($c, $this->thestring) {
        $p = strrpos($this->thestring, $c);
        return $p === false ? '' : substr($this->thestring, $p + 1);
    }
    
    public static function untilLast($c, $this->thestring) {
        $p = strrpos($this->thestring, $c);
        return $p === false ? $this->thestring : substr($this->thestring, 0, $p);
    }
    
}
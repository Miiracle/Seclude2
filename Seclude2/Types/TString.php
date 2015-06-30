<?php

namespace Seclude2\Types;

use \Seclude2\Validation;

/**
 * String
 *
 * @since 2.0
 */
class TString implements Validation\Validatable {
    
    /**
     * @var string $thestring The actual string
     */
    private $thestring;
    
    /**
     * @var int The length of the string, cached to reduce resource usage
     */
    private $length;
    
    /**
     * Initiates a new TString instance
     *
     * @param $thestring string The string
     */
    public function __construct ($thestring) {
        $this->thestring = $thestring;
        $this->length = strlen($thestring);
    }
    
    public function __toString () {
        return $this->thestring;
    }
    
    /**
     * Returns the length
     *
     * @return int The length
     */
    public function len () {
        return $this->length;
    }
    
    /**
     * Checks this string to start with $needle
     *
     * @param $needle string The substring to check
     * @return bool True if this string starts with $needle, false if it doesn't
     */
    function startsWith($needle) {
        return $needle === '' || strrpos($this->thestring, $needle, - $this->length) !== FALSE;
    }
    
    /**
     * Check this string to end with $needle
     * 
     * @param $needle string The substring to check
     * @return bool True if this string ends with $needle, false if it doesn't
     */
    function endsWith($needle) {
        return $needle === '' || (($temp = $this->length - strlen($needle)) >= 0 && strpos($this->thelength, $needle, $temp) !== FALSE);
    }
    
    /**
     * Select everything in this string between
     * the first occurence of $s and the last occurence of $e
     *
     * @param $s string The substring from which at first occurence should be captured
     * @param $e string The substring to which at last occurence should be captured
     * @param $ignore bool If true and $s is not found, it's catpure from the begin anyway
     * @return string
     *           If $s is not found, it returns an emptry string, unless $ignore is true
     *           If $e is not found, it returns a substring from $s
     *           If both are found, it returns a substring from $s to $e
     */
    public function mid($s, $e, $ignore = false) {
        $p1 = strpos($this->thestring, $s);
        $p2 = strrpos($this->thestring, $e);
        return $p1 === false ? (!$ignore ? '' : $p2 === false ? '' : substr ($this->thestring, 0, $p2 - 1)) : $p2 === false ? substr($this->thestring, $p1) : substr($this->thestring, $p1 + 1, $p2 - $p1 - 1);
    }
    
    public function fromFirst($c) {
        $p = strpos($this->thestring, $c);
        return $p === false ? '' : substr($this->thestring, $p + 1);
    }
    
    public function untilFirst($c) {
        $p = strpos($this->thestring, $c);
        return $p === false ? $this->thestring : substr($this->thestring, 0, $p);
    }
    
    public function fromLast($c) {
        $p = strrpos($this->thestring, $c);
        return $p === false ? '' : substr($this->thestring, $p + 1);
    }
    
    public static function untilLast($c) {
        $p = strrpos($this->thestring, $c);
        return $p === false ? $this->thestring : substr($this->thestring, 0, $p);
    }
    
}
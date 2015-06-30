<?php

namespace Seclude2\Helper;

use \Exception;
use \Seclude2\Types;

/**
 * Class representing a HTML Element
 * Useful for HTML generation
 *
 * @since 2.0
 */
class HtmlElement {
    
    /**
     * @var string $tagName The tag name
     */
    private $tagName;
    
    /**
     * @var HtmlElement[] $nodes All the underlining nodes
     * @var string[] $attributes The HTML attributes this element has
     */
    private $nodes = array (), $attributes = array ();
    
    /**
     * @var bool $closeTag Whether or not to use a close tag
     */
    private $closeTag = true;
    
    /**
     * Initiates a new Html Element instance
     *
     * @param string $tagName The name of the tag
     * @param bool $closeTag To use a close tag or not
     */
    public function __construct ($tagName, $closeTag = true) {
        $this->tagName = $tagName;
        $this->closeTag = $closeTag;
    }
    
    /**
     * Adds a html element as child
     *
     * @param HtmlElement $element The element
     * @return $this
     */
    public function addElement () {
        if ($this->closeTag == false)
            throw new Exception ('This is an inline element, so you cannot add children.');
        
        foreach (func_get_args () as $element)
            if ($element instanceof HtmlElement)
                $this->nodes [] = $element;
            else
                throw new Exception ('The given $element is not an instance of Element');
        
        return $this;
    }
    
    /**
     * Adds a text node as child
     *
     * @param string ...$thestring The text
     * @return $this
     */
    public function addTextNode () {
        if ($this->closeTag == false)
            throw new Exception ('This is an inline element, so you cannot add children.');
        
        foreach (func_get_args () as $thestring)
            $this->nodes [] = (string) $thestring;
        
        return $this;
    }
    
    /**
     * Adds a <br /> tag
     *
     * @return $this;
     */
    function addBr () {
        if ($this->closeTag == false)
            throw new Exception ('This is an inline element, so you cannot add children.');
        
        $this->nodes [] = new HtmlElement ('br', false);
        return $this;
    }
    
    /**
     * Set an attribute to a value
     *
     * @param string $attr The attribute name
     * @param string $value The value
     * @return $this
     */
    public function __call ($attr, $value) {
        $this->attributes [$attr] = isset ($value [0]) ? $value [0] : null;
        return $this;
    }
    
    public function __toString () {
        $nodeCount = count ($this->nodes);
        
        // The begin tag
        $output  = '<'. $this->tagName;
        
        // The attributes of the tag
        foreach ($this->attributes as $attrName => $attrValue) {
            $output .= ' '. $attrName .'="'. str_replace('"', '&quot;', $attrValue) .'"';
        }
        
        // The closing of the begin tag
        $output .= $this->closeTag ? '>'. ($nodeCount > 1 ? PHP_EOL : '') : ' />';
        
        // All the chlid nodes
        if ($this->closeTag) {
            foreach ($this->nodes as $childNode) {
                $output .= $nodeCount > 1 ? self::prefixTab ((string) $childNode) .PHP_EOL : (string) $childNode;
            }
            
            // Add the close tag
            $output .= '</'. $this->tagName .'>';
        }
        
        return $output;
    }
    
    /**
     * Adds a tab before each line
     *
     * @internal
     * @param string $thestring The string to prefix
     * @return string The inital string, with tabs before every line
     */
    private static function prefixTab ($thestring) {
        // Convert all line breaks to \n because CRLF sucks, then split the lines
        $lines = explode ("\n", str_replace (array ("\r\n", "\r"), "\n", $thestring));
        
        // Loop over each line and prefix it with a \t character
        foreach ($lines as &$line)
            $line = "\t". $line;
        
        // Return to the sender
        return implode (PHP_EOL, $lines);
    }
}
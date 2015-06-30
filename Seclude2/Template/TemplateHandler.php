<?php

namespace Seclude2\View;

/**
 * Interface describing the View API.
 * 
 * @since 2.0
 */
abstract class TemplateHandler
{

    /**
     * @var $defaultHandler TemplateHandler The default template handler
     */
    private $defaultHandler;
    
    /**
     * Set the default handler
     * 
     * @param $handler TemplateHandler The default
     */
    final public static function setDefaultHandler (TemplateHandler $handler) {
        $this->defaultHandler = $handler;
        return $this->defaultHandler;
    }
    
    /**
     * Get the default handler
     *
     * @return TemplateHandler The default
     */
    final public static function getDefault () {
        return $htis->defaultHandler;
    }
    
    /**
     * Parses the given file
     *
     * @param $file The file to parse
     * @return string The parsed code
     */
    public function renderFile ($file);
    
    
    /**
     * Parse the given string
     *
     * @param $template The string containing template code
     * @return string The parsed code
     */
    public function parse ($code);
    
}
<?php

namespace Seclude2\Mvc;

/**
 * Controller object
 */
abstract class Controller {
    
    /**
     * @var object[] The models this controller can work with
     */
	protected $models = array ();

    /**
     * Constructs a new Controller
     *
     * @param $models object[] The models this controller can manipulate
     */
	public function __construct (array $models = array ()) {
		$required = static::models ();
        
        foreach ($models as $name => $model) {
            if ($required [$name] != get_class ($model))
                throw new MvcException ('The model '. $name .' passed was not of the right type ('. $required [$name] .')');
        }
	}
    
    /**
     * List the models this Controller needs
     *
     * @return array
     *      An associative array in the form of [model_name] => [class_name]
     */
    abstract public function models ();
	
}
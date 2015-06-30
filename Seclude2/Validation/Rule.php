<?php

namespace Seclude2\Validation;

/**
 * Validation rule
 *
 * @since 2.0
 */
interface Rule {

	/**
	 * Checks whether the $value follows the rule
     *
     * @param $value mixed The value to check
	 */
	public function followedBy ($value);

}
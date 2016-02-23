<?php

class API
{
	/**
	 *
	 *
	 *
	 */
	private function execute() {

	}

	/**
	 * Method that requires all the files.
	 *
	 * @method requireAll
	 * @private
	 */
	private function requireAll() {
		// Require all models.
		foreach (scandir(dirname(__DIR__) . '/models/') as $filename) {
			$path = dirname(__DIR__) . '/models/' . $filename;

			if (is_file($path)) {
				require_once($path);
			}
		}
	}


	/**
	 * Method that is executed when the API is called.
	 *
	 * @method __construct
	 * @public
	 */
	public function __construct() {
		$this->requireAll();
	}
}

$API = new API();

?>
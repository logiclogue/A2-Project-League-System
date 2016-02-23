<?php

/**
 * Allows the JavaScript to communicate with the PHP models.
 *
 * @class API
 */
class API
{
	/**
	 * Name of the model to be called.
	 *
	 * @property modelName
	 * @private
	 * @type String
	 */
	private $modelName;


	/**
	 * Creates an instance of the class requested.
	 * Therefore calling the model.
	 *
	 * @method execute
	 * @private
	 */
	private function execute() {
		$model = new $this->modelName();
	}

	/**
	 * Gets the data from GET or POST.
	 *
	 * @method getData
	 * @private
	 */
	private function getData() {
		if (isset($_POST)) {
			$this->modelName = $_POST['model'];
		}
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
	 * Calls all of the other methods.
	 *
	 * @method __construct
	 * @public
	 */
	public function __construct() {
		$this->requireAll();
		$this->getData();
		$this->execute();
	}
}

$API = new API();

?>
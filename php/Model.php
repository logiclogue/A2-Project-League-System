<?php

/**
 * Model class, the class is extended by all models.
 * It provides a foundation for all models.
 *
 * @class Model
 */
class Model
{
	/**
	 * The name of the data variable in POST.
	 *
	 * @property name
	 * @private
	 */
	private $name = 'JSON';

	/**
	 * The data object is used to store.
	 *
	 * @property data
	 * @type Array
	 * @protected
	 */
	protected $data = array();

	/**
	 * The object for holding all data that wants to be returned.
	 *
	 * @property return_data
	 * @type Array
	 * @protected
	 */
	protected $return_data;

	/**
	 * Whether model executed successfully.
	 *
	 * @property success
	 * @type {Boolean} Default true.
	 * @protected
	 */
	protected $success;

	/**
	 * Error message string, if error.
	 *
	 * @property error_msg
	 * @type String
	 * @protected
	 */
	protected $error_msg;


	/**
	 * Method that assembles the return object.
	 *
	 * @method returnObj
	 * @private
	 * @return {Array} Return object.
	 */
	private function returnObj() {
		$obj = array();

		if ($this->success) {
			$obj = $this->return_data;
		}
		else {
			$obj['error_msg'] = $this->error_msg;
		}

		$obj['success'] = $this->success;

		return $obj;
	}

	/**
	 * This method is used to decode the JSON data in the post.
	 *
	 * @method decodePost
	 * @private
	 * @return {Object} The decoded JSON.
	 */
	private function decodePost() {
		if (isset($_POST[$this->name])) {
			return json_decode($_POST[$this->name], true);
		}
	}

	/**
	 * This returns whether the post data variable is set.
	 *
	 * @method isPost
	 * @private
	 * @return {Boolean} Whether it's set.
	 */
	private function isPost() {
		return isset($_POST[$this->name]);
	}

	/**
	 * Resets variables when model is called.
	 *
	 * @method setVars
	 * @private
	 */
	protected function setVars() {
		$this->return_data = array();
		$this->success = true;
		$this->error_msg = '';
	}


	/**
	 * Call allows PHP to pass data into the model.
	 *
	 * @method call
	 * @public
	 * @param {Object} Data object to interact with the model.
	 * @return {Object} Return data.
	 */
	public function call($data) {
		$this->data = $data;

		$this->setVars();
		$this->main();

		return $this->returnObj();
	}

	/**
	 * Function that is called to check if it is called with Post.
	 *
	 * @method __construct
	 * @public
	 * @param notAPI {Boolean}
	 */
	public function __construct($notAPI) {
		// If not being called as API, then unset POST.
		if ($notAPI) {
			unset($_POST);
		}

		// If called as API.
		if ($this->isPost()) {
			$this->data = $this->decodePost();

			$this->setVars();
			$this->main();

			echo json_encode($this->returnObj());
		}
	}
}

?>

<?php

/**
 * Model class, the class is extended by all models.
 * It provides a foundation for all models.
 *
 * @class Model
 * @static
 */
class Model
{
	/**
	 * The name of the data variable in POST.
	 *
	 * @property name
	 * @private
	 */
	private static $name = 'JSON';

	/**
	 * The data object is used to store.
	 *
	 * @property data
	 * @type Array
	 * @protected
	 */
	protected static $data = array();

	/**
	 * The object for holding all data that wants to be returned.
	 *
	 * @property return_data
	 * @type Array
	 * @protected
	 */
	protected static $return_data;

	/**
	 * Whether model executed successfully.
	 *
	 * @property success
	 * @type {Boolean} Default true.
	 * @protected
	 */
	protected static $success;

	/**
	 * Error message string, if error.
	 *
	 * @property error_msg
	 * @type String
	 * @protected
	 */
	protected static $error_msg;


	/**
	 * Method that assembles the return object.
	 *
	 * @method returnObj
	 * @private
	 * @return {Array} Return object.
	 */
	private static function returnObj() {
		$obj = array();

		if (self::$success) {
			$obj = self::$return_data;
		}
		else {
			$obj['error_msg'] = self::$error_msg;
		}

		$obj['success'] = self::$success;

		return $obj;
	}

	/**
	 * This method is used to decode the JSON data in the post.
	 *
	 * @method
	 * @private
	 * @return {Object} The decoded JSON.
	 */
	private static function decodePost() {
		if (isset($_POST[self::$name])) {
			return json_decode($_POST[self::$name], true);
		}
	}

	/**
	 * This returns whether the post data variable is set.
	 *
	 * @method isPost
	 * @private
	 * @return {Boolean} Whether it's set.
	 */
	private static function isPost() {
		return isset($_POST[self::$name]);
	}

	/**
	 * Resets variables when model is called.
	 *
	 * @method setVars
	 * @private
	 */
	protected static function setVars() {
		self::$return_data = array();
		self::$success = true;
		self::$error_msg = '';
	}


	/**
	 * Call allows PHP to pass data into the model.
	 *
	 * @method call
	 * @public
	 * @param {Object} Data object to interact with the model.
	 * @return {Object} Return data.
	 */
	public static function call($data) {
		self::$data = $data;

		self::setVars();
		static::main();

		return self::returnObj();
	}

	/**
	 * Function that is called to check if it is called with Post.
	 *
	 * @method init
	 * @public
	 */
	public static function init() {
		if (self::isPost()) {
			self::$data = self::decodePost();

			self::setVars();
			static::main();

			echo json_encode(self::returnObj());
		}
	}
}

?>
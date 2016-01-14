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
	protected static $return_data = array();

	/**
	 * Whether model executed successfully.
	 *
	 * @property success
	 * @type Boolean
	 * @protected
	 */
	protected static $success = true;

	/**
	 * Error message string, if error.
	 *
	 * @property error_msg
	 * @type String
	 * @protected
	 */
	protected static $error_msg = '';


	/**
	 * Method that assembles the return object.
	 *
	 * @method returnObj
	 * @private
	 * @return {Array} Return object.
	 */
	private static function returnObj() {
		 $obj = self::$return_data;

		 $obj['success'] = self::$success;
		 $obj['error_msg'] = self::$error_msg;

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
	 * Call allows PHP to pass data into the model.
	 *
	 * @method call
	 * @public
	 * @param {Object} Data object to interact with the model.
	 * @return {} The return of child @method main.
	 */
	public static function call($data) {
		self::$data = $data;

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

			static::main();

			echo json_encode(self::returnObj());
		}
	}
}

?>
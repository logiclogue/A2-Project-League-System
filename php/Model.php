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
	 * @type Object
	 */
	protected static $data = array();


	/**
	 * This method is used to decode the JSON data in the post.
	 *
	 * @method
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
	 * @return {Boolean} Whether it's set.
	 */
	private static function isPost() {
		return isset($_POST[self::$name]);
	}


	/**
	 * Call allows PHP to pass data into the model.
	 *
	 * @method call
	 * @param {Object} Data object to interact with the model.
	 * @return {} The return of child @method main.
	 */
	public static function call($data) {
		self::$data = $data;

		return static::main();
	}

	/**
	 * Function that is called to check if it is called with Post.
	 *
	 * @method init
	 */
	public static function init() {
		if (self::isPost()) {
			self::$data = self::decodePost();

			echo json_encode(static::main());
		}
	}
}

?>
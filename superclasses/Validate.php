<?php

/**
 * Class used to validate input text.
 *
 * @class Validate
 */
class Validate
{
	/**
	 * Returns standard data such as whether success, error message, and correction.
	 *
	 * @method returnData
	 * @private
	 * @static
	 * @param success {Boolean} Whether a success or not.
	 * @param error_msg {String} Error message.
	 * @return {Array}
	 *   @return [].success {Boolean} Whether a success or not.
	 *   @return [].error_msg {String} Error message.
	 */
	private static function returnData($success, $error_msg) {
		return array(
			'success' => $success,
			'error_msg' => $error_msg
		);
	}


	/**
	 * Valididates user's name.
	 * Can be first or last name.
	 *
	 * @method userName
	 * @static
	 * @param name {String} Name to be checked.
	 * @param variableName {String} Name of variable e.g. 'First name' or 'Last name'.
	 * @return {Object} Return of @method returnData
	 */
	public static function userName($name, $variableName) {
		// Regex, matching name.
		preg_match("/^[A-z']+$/", $name, $match);

		// Check only alphabetical characters using regex.
		if ($match[0] != $name) {
			return self::returnData(false, $variableName . ' must only be alphabetical characters');
		}
		// Check length > 1.
		if (strlen($name) < 2) {
			return self::returnData(false, $variableName . ' must contain at least 2 characters');
		}
		// Check length <= 30.
		if (strlen($name) > 30) {
			return self::returnData(false, $variableName . ' must contain at most 30 characters');
		}

		return self::returnData(true, null);
	}

	/**
	 * Validates tournament name.
	 *
	 * @method tournamentName
	 * @static
	 * @param name {String}
	 * @return {Object} Return of @method returnData
	 */
	public static function tournamentName($name) {
		// Regex
		preg_match("/^[A-z0-9' !@#$%^&*()£\/?,.]+$/", $name, $match);

		// Check only a-zA-Z0-9 and spaces using regex.
		if ($match[0] != $name) {
			return self::returnData(false, 'Tournament name can only contain alphanumerical or !@#$%^&*()£/?,. characters');
		}
		// Check length > 5.
		if (strlen($name) < 5) {
			return self::returnData(false, 'Tournament name must be at least 5 characters');
		}
		// Check length <= 40.
		if (strlen($name) > 40) {
			return self::returnData(false, 'Tournament name must be at most 40 characters');
		}

		return self::returnData(true, null);
	}

	/**
	 * Validates email address.
	 *
	 * @method email
	 * @static
	 * @param email {String}
	 * @return {Object} Return of @method returnData
	 */
	public static function email($email) {
		// Regex
		preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $email, $match);

		// Check using valid email regex.
		if ($match[0] != $email) {
			return self::returnData(false, 'Email is not valid');
		}

		return self::returnData(true, null);
	}

	/**
	 * Validates password.
	 *
	 * @method password
	 * @static
	 * @param password {String}
	 * @return {Object} Return of @method returnData
	 */
	public static function password($password) {
		// Check length > 5.
		if (strlen($password) < 6) {
			return self::returnData(false, 'Password must be at least 6 characters');
		}

		return self::returnData(true, null);
	}

	/**
	 * Validates phone number.
	 *
	 * @method phoneNumber
	 * @static
	 * @param phoneNumber {String}
	 * @return {Object} Return of @method returnData
	 */
	public static function phoneNumber($number) {
		// Regex
		preg_match("/^[0-9 ]+$/", $number, $match);

		// Check only numerical characters, using regex.
		if ($match[0] != $number) {
			return self::returnData(false, 'Phone number must only contain numerical characters and spaces');
		}
		// Check length < 5.
		if (strlen($number) < 5) {
			return self::returnData(false, 'Phone number must be at least 6 characters long');
		}
		// Check length > 20.
		if (strlen($number) > 20) {
			return self::returnData(false, 'Phone number must be at most 20 characters long');
		}

		return self::returnData(true, null);
	}
}

?>
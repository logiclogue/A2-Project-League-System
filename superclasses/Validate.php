<?php

/**
 * Class used to validate input text.
 *
 * @class Validate
 */
class Validate
{
	/**
	 * Valididates user's name.
	 * Can be first or last name.
	 *
	 * @method userName
	 * @param name {String}
	 * @return {Boolean}
	 */
	public static function userName($name) {
		// Check only a-zA-Z using regex.
		// Check length > 1.
		// Check length <= 30.
	}

	/**
	 * Validates tournament name.
	 *
	 * @method tournamentName
	 * @param name {String}
	 * @return {Boolean}
	 */
	public static function tournamentName($name) {
		// Check only a-zA-Z0-9 using regex.
		// Check length > 5.
		// Check length <= 40.
	}

	/**
	 * Validates email address.
	 *
	 * @method email
	 * @param email {String}
	 * @return {Boolean}
	 */
	public static function email($email) {
		// Check using valid email regex.
	}

	/**
	 * Validates password.
	 *
	 * @method password
	 * @param password {String}
	 * @return {Boolean}
	 */
	public static function password($password) {
		// Check length > 5.
	}

	/**
	 * Validates phone number.
	 *
	 * @method phoneNumber
	 * @param phoneNumber {String}
	 * @return {Boolean}
	 */
	public static function phoneNumber($number) {
		// Check length > 5.
		// Check length <= 20.
	}
}

?>
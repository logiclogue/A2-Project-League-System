<?php

class Model
{
	protected static $data = array();


	public static function call($data) {
		self::$data = $data;

		return static::main();
	}

	public static function init() {
		if (GetJSON::isPost()) {
			self::$data = GetJSON::decodePost();

			echo json_encode(static::main());
		}
	}
}

?>
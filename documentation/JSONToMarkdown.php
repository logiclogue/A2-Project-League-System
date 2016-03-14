<?php

class JSONToMarkdown
{
	private $file;
	private $data;
	private $classes = array();


	private function getClasses() {
		foreach($this->data->classes as &$class) {
			$class->items = array();

			array_push($this->classes, $class);

			echo '<h2>' . $class->name . '</h2>';
			echo '<i>' . $class->description . '</i><br>';
			echo 'Line: ' . $class->line . ' in file ' . $class->file . '<br>';
			echo 'Extends: ' . $class->extends;
		}
	}

	private function getClassItems() {
		foreach($this->data->classitems as &$item) {
			echo $item->itemtype . '<br>';

			if (!in_array($item->itemtype, $this->class->items)) {
				$this->class->items[$item->itemtype] = array();
			}

			array_push($item, $this->class->items[$item->itemtype]);
		}

		print_r($this->classes->items);
	}


	public function __construct() {
		$this->file = file_get_contents(dirname(__FILE__) . '/yuidoc.json');
		$this->data = json_decode($this->file);

		//$this->getClasses();
		$this->getClassItems();
	}
}


$jsonToMarkdown = new JSONToMarkdown();

?>
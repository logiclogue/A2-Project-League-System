<?php

require_once(dirname(__DIR__) . "/lib/Parsedown.php");


class JSONToMarkdown
{
	private $file;
	private $data;
	private $text;


	private function printLine($text) {
		$this->text .= $text . "\r\n\n";
	}

	private function getClasses() {
		foreach($this->data->classes as &$class) {
			$this->printLine("## " . $class->name);
			$this->printLine("*" . $class->description . "*");
			$this->printLine("Line: " . $class->line . " in file " . $class->file);
			$this->printLine("Extends: " . $class->extends);
			$this->printLine("### Properties:");

			foreach($class->classitems["property"] as &$property) {
				$this->printLine("#### " . $property->name);

				$this->printLine("*" . $property->description . "*");
				$this->printLine("Line: " . $property->line);
				$this->printLine("Access: " . $property->access);
				$this->printLine("Type: " . $property->type);
			}
			$this->printLine("### Methods:");

			foreach($class->classitems["method"] as &$method) {
				$this->printLine("#### " . $method->name);

				$this->printLine("*" . $method->description . "*");
				$this->printLine("Line: " . $method->line);
				$this->printLine("Access: " . $method->access);

				if (count($method->params) != 0) {
					$this->printLine("**Parameters**");
				}

				foreach($method->params as &$param) {
					$this->printLine("* " . $param->name . ": " . $param->type . " (*" . $param->description . "*)");
				}
			}
		}
	}

	private function getClassItems() {
		foreach($this->data->classitems as &$item) {
			$this->data->classes->{$item->class}->classitems[$item->itemtype][] = $item;

			$this->items[$item->itemtype][] = $item;
		}
	}

	private function markdownToHTML() {
		$parsedown = new Parsedown();

		//echo $parsedown->text($this->text);
		echo $this->text;
	}


	public function __construct() {
		$this->file = file_get_contents(dirname(__FILE__) . "/yuidoc.json");
		$this->data = json_decode($this->file);

		$this->getClassItems();
		$this->getClasses();
		$this->markdownToHTML();
	}
}


$jsonToMarkdown = new JSONToMarkdown();

?>
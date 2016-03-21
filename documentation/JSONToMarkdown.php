<?php

require_once(dirname(__FILE__) . '/Doc.php');
require_once(dirname(__DIR__) . "/lib/Parsedown.php");


class JSONToMarkdown extends Doc
{
	private $file;
	private $data;
	private $text;
	private $path = "/home/jordan/workspace/sites/computing-project";


	private function printLine($text) {
		$this->text .= $text . "\r\n\n";
	}

	private function getModelParams() {
		$code = file_get_contents(dirname(__FILE__) . "/../models/Login.php");

		preg_match("/\/\*\&(.|\n)*?\*\//", $code, $matches);

		$this->printLine($matches[0]);
	}

	private function getClasses() {
		foreach($this->data->classes as &$class) {
			$class->file = str_replace($this->path, "", $class->file);

			$this->printLine("## " . $class->name);
			$this->printLine("*" . $class->description . "*");
			$this->printLine("Line: " . $class->line . " in file " . $class->file);
			$this->printLine("Extends: " . $class->extends);

			if (count($class->classitems["property"]) != 0) {
				$this->printLine("### Properties:");
			}

			foreach($class->classitems["property"] as &$property) {
				$this->printLine("#### " . $property->name);

				$this->printLine("*" . $property->description . "*");
				$this->printLine("Line: " . $property->line);
				$this->printLine("Access: " . $property->access);
				$this->printLine("Type: " . $property->type);
			}

			if (count($class->classitems["method"]) != 0) {
				$this->printLine("### Methods:");
			}

			foreach($class->classitems["method"] as &$method) {
				$params = "";

				foreach($method->params as &$param) {
					if ($params != "") {
						$params .= ", ";
					}

					$params .= $param->name;
				}

				$this->printLine("#### " . $method->name . "($params)");

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

			$this->printLine("<hr>");
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

		echo $parsedown->text($this->text);
		//echo $this->text;
	}


	public function __construct() {
		$this->file = file_get_contents(dirname(__FILE__) . "/yuidoc.json");
		$this->data = json_decode($this->file);

		//$this->getModelParams();
		$this->getClassItems();
		$this->getClasses();
		$this->markdownToHTML();
	}
}


$jsonToMarkdown = new JSONToMarkdown();

?>
<?php

require_once(dirname(__FILE__) . '/Doc.php');
require_once(dirname(__DIR__) . "/lib/Parsedown.php");


class JSONTOLaTeX extends Doc
{
	private $file;
	private $data;
	private $text;
	private $path = "/home/jordan/workspace/sites/computing-project";
	private $classes = array();


	private function printLine($text) {
		//$this->text .= $text . "\r\n\n";
	}

	private function replace($val) {
		$val = str_replace("_", "\_", $val);
		$val = str_replace("$", "\\$", $val);

		return $val;
	}

	private function getModelParams() {
		$code = file_get_contents(dirname(__FILE__) . "/../models/Login.php");

		preg_match("/\/\*\&(.|\n)*?\*\//", $code, $matches);

		$this->printLine($matches[0]);
	}

	private function printProperty(&$property) {
		echo "\\texttt{" . $this->replace($property->name) . "}\n\n";
		echo "{\\scriptsize\n";
		echo "\\textit{" . $property->description . "}\n\n";
		echo "Type: " . $property->type . "\n\n";

		if (isset($property->access)) {
			echo "Access: " . $property->access . "\n\n";
		}

		echo "Line: " . $property->line . "\n\n";
		echo "}\n";
	}

	private function printMethod(&$method) {
		// Print title
		echo "\\texttt{" . $this->replace($method->name) . "(";

		// Print params in title
		if (isset($method->params)) {
			foreach ($method->params as $key => $param) {
				echo $this->replace($param->name);

				if (count($method->params) != $key + 1) {
					echo ", ";
				}
			}
		}

		echo ")}\n\n";

		echo "{\\scriptsize\n";
		echo "\\textit{" . $this->replace($method->description) . "}\n\n";

		if (isset($method->access)) {
			echo "Access: " . $method->access . "\n\n";
		}
		
		echo "}\n\n";
	}

	private function printClass(&$class) {
		$properties = $class->classitems["property"];
		$methods = $class->classitems["method"];

		echo "\\textit{" . $class->description . "}\n\n";
		echo "Page \pageref{" . $class->file_name . "}\n\n";
		echo "File " . str_replace($this->path, "", $class->file) . "\n\n";

		if (isset($class->extends)) {
			echo "Extends \\texttt{" . $class->extends . "}\n\n";
		}

		// Properties
		foreach ($properties as $key => &$property) {
			if ($key == 0) {
				echo "\\textbf{Properties:}\n\n";
			}

			$this->printProperty($property);
		}

		// Methods
		foreach ($methods as $key => &$method) {
			if ($key == 0) {
				echo "\\textbf{Methods:}\n\n";
			}

			$this->printMethod($method);
		}
	}

	private function getClasses() {
		foreach ($this->classes as $class_type => $classes) {
			echo "\subsection{" . $class_type . "}\n";

			foreach ($classes as $class) {
				echo "\subsubsection{" . $class->name . "}\n";

				$this->printClass($class);
			}
		}
	}

	private function sortClasses() {
		foreach ($this->data->classes as $key => $class) {
			$local_path = str_replace($this->path, "", $class->file);
			$exploded_path = explode("/", $local_path);
			$class_type = $exploded_path[1];
			$file_name = $exploded_path[2];

			$class->file_name = $file_name;

			$this->classes[$this->class_type_name[$class_type]][] = $class;
		}
	}

	private function getClassItems() {
		foreach ($this->data->classitems as &$item) {
			$this->data->classes->{$item->class}->classitems[$item->itemtype][] = $item;

			$this->items[$item->itemtype][] = $item;
		}
	}

	private function markdownToHTML() {
		$parsedown = new Parsedown();

		echo $parsedown->text($this->text);
		echo $this->text;
	}


	public function __construct() {
		$this->file = file_get_contents(dirname(__FILE__) . "/yuidoc.json");
		$this->data = json_decode($this->file);

		$this->getClassItems();
		$this->sortClasses();
		//$this->getModelParams();
		$this->getClasses();
		//$this->markdownToHTML();

		//print_r($this->classes);
	}
}


$JSONTOLaTeX = new JSONTOLaTeX();

?>

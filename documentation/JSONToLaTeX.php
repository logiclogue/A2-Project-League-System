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


	private function replace($val) {
		$val = str_replace("_", "\_", $val);
		$val = str_replace("$", "\\$", $val);

		return $val;
	}

	private function getModelParams($path) {
		$code = file_get_contents($path);

		preg_match("/\/\*\&(.|\n)*?\*\//", $code, $matches);

		$match = $matches[0];

		preg_match_all("/@param [^\n]*/", $match, $params);
		preg_match_all("/@return [^\n]*/", $match, $returns);

		$params = $params[0];
		$returns = $returns[0];

		foreach ($params as $key => &$param) {
			if ($key == 0) {
				echo "\\textbf{Input:}\n";
				echo "\\begin{itemize}\n";
			}

			$param = str_replace("@param ", "", $param);
			$param = explode(" {", $param);
			$variable = $param[0];
			$param = explode("} ", $param[1]);
			$type = $param[0];
			$description = $param[1];

			echo "\\item ";
			echo "\\texttt{" . $this->replace($variable) . "}";
			
			if (isset($type)) {
				echo " - " . $type;
			}

			if (isset($description)) {
				echo " - \\textit{" . $description . "}";
			}

			echo "\n";

			if ($key == count($params) - 1) {
				echo "\\end{itemize}\n\n";
			}
		}

		foreach ($returns as $key => &$return) {
			if ($key == 0) {
				echo "\\textbf{Output:}\n";
				echo "\\begin{itemize}\n";
			}

			$return = str_replace("@return ", "", $return);
			$return = explode(" {", $return);
			$variable = $return[0];
			$return = explode("} ", $return[1]);
			$type = $return[0];
			$description = $return[1];

			echo "\\item ";
			echo "\\texttt{" . $this->replace($variable) . "}";
			
			if (isset($type)) {
				echo " - " . $type;
			}

			if (isset($description)) {
				echo " - \\textit{" . $description . "}";
			}

			echo "\n";

			if ($key == count($returns) - 1) {
				echo "\\end{itemize}\n\n";
			}
		}
	}

	private function printProperty(&$property) {
		echo "\\texttt{" . $this->replace($property->name) . "}\n\n";
		echo "{\\scriptsize\n";
		echo "\\textit{" . $property->description . "}\n\n";
		echo "Type: " . $property->type . "\n\n";

		if (isset($property->access)) {
			echo "Access: " . $property->access;

			if ($property->static) {
				echo " static\n\n";
			}
			else {
				echo "\n\n";
			}
		}

		echo "Line: " . $property->line . "\n\n";
		echo "}\n";
	}

	private function printMethodParams(&$method) {
		if (isset($method->params)) {
			foreach ($method->params as $key => $param) {
				if ($key == 0) {
					echo "Parameters:\n\n";
					echo "\\begin{enumerate}\n";
				}

				echo "\\item \\texttt{" . $this->replace($param->name) . "} - " . $param->type . " - \\textit{" . $param->description . "}\n";
				
				if ($key == count($method->params) - 1) {
					echo "\\end{enumerate}\n";
				}
			}
		}
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

		// End title
		echo ")}\n\n";

		echo "{\\scriptsize\n";
		echo "\\textit{" . $this->replace($method->description) . "}\n\n";

		if (isset($method->access)) {
			echo "Access: " . $method->access;

			if ($method->static) {
				echo " static\n\n";
			}
			else {
				echo "\n\n";
			}

			echo "Line: " . $method->line . "\n\n";
			
			$this->printMethodParams($method);

			if (isset($method->return)) {
				echo "Returns: " . $method->return->type . " - \\textit{" . $this->replace($method->return->description) . "}\n\n";
			}
		}
		
		echo "}\n\n";
	}

	private function printClass(&$class) {
		$properties = $class->classitems["property"];
		$methods = $class->classitems["method"];

		echo "\\textit{" . $class->description . "}\n\n";
		echo "Page: \pageref{" . $class->file_name . "}\n\n";
		echo "File: " . str_replace($this->path, "", $class->file) . "\n\n";

		if (isset($class->extends)) {
			echo "Extends \\texttt{" . $class->extends . "}\n\n";
		}

		$this->getModelParams($class->file);

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
				echo "\subsubsection{" . $class->name . "}\\label{" . $class->file_name . ".doc}\n";

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
		$this->getClasses();

		//print_r($this->classes);
	}
}


$JSONTOLaTeX = new JSONTOLaTeX();

?>

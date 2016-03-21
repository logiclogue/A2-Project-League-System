<?php

require_once(dirname(__FILE__) . '/Doc.php');


class CodeToLaTeX extends Doc
{
	private function getFile($path, $value) {
		echo "\\textbf{" . $value . "}\n\n";
		echo "Path: " . str_replace(dirname(__FILE__) . "/..", "", $path) . "\n";

		echo "{\\scriptsize\n";
		echo "\begin{lstlisting}\n";
		echo file_get_contents($path);
		echo "\\end{lstlisting}\n";
		echo "}\n";
	}

	private function foreachFile($dir) {
		foreach (scandir($dir) as $key => $value) {
			if ($key != 0 && $key != 1) {
				$path = $dir . "/" . $value;

				$this->getFile($path, $value);
			}
		}
	}

	private function loopAll($val, $level) {
		foreach ($val as $key => $value) {
			if ($level == 1) {
				echo "\\newpage\n";
				echo "\subsection{" . $key . "}\n";
			}
			else {
				echo "\subsubsection{" . $key . "}\n";
			}

			if (is_array($value)) {
				$this->loopAll($value, 2);
			}
			else {
				$dir = dirname(__FILE__) . '/../' . $value;

				if (is_dir($dir)) {
					$this->foreachFile($dir);
				}
				else {
					$this->getFile($dir, str_replace(dirname(__FILE__) . '/../', "", $dir));
				}
			}
		}
	}


	public function __construct() {
		$this->loopAll($this->paths, 1);
	}
}

$CodeToLaTeX = new CodeToLaTeX();

?>
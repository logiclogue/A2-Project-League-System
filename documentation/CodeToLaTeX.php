<?php

class CodeToLaTeX
{
	private $paths = array(
		'PHP' => array(
			'Models' => 'models',
			'Important Classes' => 'php',
			'Parent Classes' => 'superclasses'
		),
		'JavaScript' => array(
			'Configuration' => 'app',
			'Controllers' => 'controllers',
			'Directives' => 'directives',
			'Services' => 'services'
		),
		'CSS' => 'css',
		'HTML' => 'views',
		'SQL' => 'database.sql'
	);


	private function getFile($path) {
		echo "\begin{lstlisting}\n";
		echo file_get_contents($path);
		echo "\\end{lstlisting}\n";
	}

	private function foreachFile($dir) {
		foreach (scandir($dir) as $key => $value) {
			$this->getFile($dir . "/" . $value);
		}
	}

	private function loopAll($val, $level) {
		foreach ($val as $key => $value) {
			if ($level == 1) {
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
					echo $dir . "\n";
				}
			}
		}
	}


	public function __construct() {
		$this->loopAll($this->paths, 1);
		//$this->getFile(dirname(__FILE__) . '/../database.sql');
	}
}

$CodeToLaTeX = new CodeToLaTeX();

?>
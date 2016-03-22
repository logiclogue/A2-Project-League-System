<?php

class Doc
{
	protected $paths = array(
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

	protected $class_type_name = array(
		'models' => 'PHP - Models',
		'php' => 'PHP - Important Classes',
		'superclasses' => 'PHP - Parent Classes',
		'services' => 'JavaScript - Services',
		'directives' => 'JavaScript - Directives',
		'controllers' => 'JavaScript - Controllers'
	);
}

?>

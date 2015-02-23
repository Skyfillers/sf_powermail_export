<?php

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Powermail CSV export command',
	'description' => 'Scheduler Task to export e-mails from powermail 2.x as CSV',
	'category' => 'plugin',
	'author' => 'Torben Hansen',
	'author_email' => 't.hansen@skyfillers.com',
	'author_company' => 'Skyfillers GmbH',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.1.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.2.0-6.2.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);

?>
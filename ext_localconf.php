<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

/**
 * CommandController for powermail export tasks
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'SKYFILLERS\\SfPowermailExport\\Command\\PowermailExportCommandController';
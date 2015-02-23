<?php
namespace SKYFILLERS\SfPowermailExport\Command;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Torben Hansen <t.hansen@skyfillers.com>, Skyfillers GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

Use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ExportCommandController
 */
class PowermailExportCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController {

	/**
	 * mailRepository
	 *
	 * @var \SKYFILLERS\SfPowermailExport\Domain\Repository\MailRepository
	 * @inject
	 */
	protected $mailRepository;

	/**
	 * Export mails as CSV
	 *
	 * @param string $pidList List of PIDs with e-mails
	 * @param int $timeframe Timeframe (seconds)
	 * @param string $exportPath The export path
	 * @param string $exportFilename The export filename
	 * @return void
	 */
	public function csvCommand($pidList, $timeframe = NULL, $exportPath, $exportFilename) {
		$querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$querySettings->setRespectStoragePage(FALSE);
		$this->mailRepository->setDefaultQuerySettings($querySettings);

		$mails = $this->mailRepository->findExportMails($pidList, $timeframe);

		// Exit if path could not be found
		if (!file_exists(GeneralUtility::getFileAbsFileName($exportPath))) {
			$this->outputLine('Error: Export path could not be found.');
			exit();
		}

		if ($mails->count() == 0) {
			$this->outputLine('Export finished - no new e-mails found.');
			exit();
		}


		$exportData = '';
		$csvHeader = '';
		foreach ($mails as $mail) {
			$tmpheader = array();
			$mailData = array();
			foreach($mail->getAnswers() as $answer) {
				if ($csvHeader == '') {
					$tmpheader[] = $answer->getField()->getTitle();
				}
				//$mailData[] = $answer->_getCleanProperty('value');
				switch ($answer->getField()->getType()) {
					case 'date':
						if ($answer->_getCleanProperty('value') != '') {
							$mailData[] = date('d.m.Y', (int)$answer->_getCleanProperty('value'));
						} else {
							$mailData[] = '';
						}
						break;
					default:
						$mailData[] = $answer->_getCleanProperty('value');
				}
			}
			if ($csvHeader === '') {
				$csvHeader = GeneralUtility::csvValues($tmpheader, ';') . chr(10);
			}
			$exportData .= GeneralUtility::csvValues($mailData, ';') . chr(10);
		}

		$filename = GeneralUtility::getFileAbsFileName($exportPath . $exportFilename);
		if (file_exists($filename)) {
			$oldContent = file_get_contents($filename);
			$content = $oldContent . $exportData;
		} else {
			$content = $csvHeader . $exportData;
		}

		// Finally write export file
		GeneralUtility::writeFile($filename, $content);

		$this->outputLine('Export finished - e-mails exported: ' . $mails->count());
	}

}
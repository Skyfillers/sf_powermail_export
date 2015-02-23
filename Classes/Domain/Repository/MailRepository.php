<?php
namespace SKYFILLERS\SfPowermailExport\Domain\Repository;

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
 * Class MailRepository
 */
class MailRepository extends \In2code\Powermail\Domain\Repository\MailRepository {

	/**
	 * Returns all emails to be exported
	 *
	 * @param $pidlist
	 * @param $timeframe
	 *
	 * @return mixed
	 */
	public function findExportMails($pidlist, $timeframe) {
		$pids = GeneralUtility::trimExplode(',', $pidlist, TRUE);

		/** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		$query->getQuerySettings()->setIgnoreEnableFields(TRUE);

		// initial filter
		$and = array(
			$query->equals('deleted', 0),
			$query->in('pid', $pids)
		);

		if ($timeframe) {
			$and[] = $query->greaterThanOrEqual('crdate', time() - (int)$timeframe);
		}

		// create constraint
		$constraint = $query->logicalAnd($and);
		$query->matching($constraint);

		// go for it
		$mails = $query->execute();
		return $mails;
	}

}

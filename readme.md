Powermail CSV export command
============================

## What is it?

This TYPO3 CMS extensions adds a scheduler task to export saved powermail e-mail messages to a CSV file.

## Usage

* Install the extension
* Create a new scheduler task
* Select "Extbase-CommandController-Task" as task class
* Select "SfPowermailExport" as command controller
* Fill out all arguments for the export task

### Arguments

* pidList - one or multiple PIDs with saved powermail e-mails
* timeframe - amount of seconds which the task looks back for new e-mails (e.g. 3600 exports all emails, that have been created since one hour ago)
* exportPath - export path (e.g. fileadmin/export)
* exportFilename - the export filename (e.g. export.csv)

## Feedback and updates

This extension is hosted in GitHub. Please report feedback, bugs and change requests directly at
https://github.com/Skyfillers/sf_powermail_export
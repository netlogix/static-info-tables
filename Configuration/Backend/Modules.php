<?php
declare(strict_types = 1);

use SJBR\StaticInfoTables\Controller\ManagerController;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Registers the Static Info Tables Manager backend module, if enabled
 */
if (GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('static_info_tables')['enableManager'] ?? false) {
	return [
		'staticinfomanager' => [
			'parent' => 'admin',
			'position' => [],
			'access' => 'admin',
			'workspaces' => '*',
			'identifier' => 'staticinfomanager',
			'isStandalone' => false,
			'path' => '/module/admin/staticinfomanager',
			'iconIdentifier' => 'static-info-tables-icon',
			'labels' => [
				'title' => 'LLL:EXT:static_info_tables/Resources/Private/Language/locallang_mod.xlf:mlang_tabs_tab',
				'description' => 'LLL:EXT:static_info_tables/Resources/Private/Language/locallang_mod.xlf:mlang_labels_tabdescr',
				'shortDescription' => 'LLL:EXT:static_info_tables/Resources/Private/Language/locallang_mod.xlf:mlang_labels_tablabel'
			],
			'showSubmoduleOverview' => false,
			'extensionName' => 'StaticInfoTables',
			'controllerActions' => [
				ManagerController::class => [
					'information',
					'newLanguagePack',
					//'createLanguagePack',
					'testForm',
					//'testFormResult',
					'sqlDumpNonLocalizedData'
				]
			]
		]
	];
} else {
	return [];
}
<?php
defined('TYPO3') or die();

use SJBR\StaticInfoTables\Cache\ClassCacheManager;
use SJBR\StaticInfoTables\Hook\Core\DataHandling\ProcessDataMap;
use TYPO3\CMS\Core\Cache\Backend\FileBackend;
use TYPO3\CMS\Core\Cache\Frontend\PhpFrontend;

$cacheKey = 'static_info_tables';

if (!isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheKey])
    || !is_array($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheKey])
) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheKey] = [
        'groups' => ['all'],
    ];
}
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheKey]['frontend']
    ??= PhpFrontend::class;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheKey]['backend']
    ??= FileBackend::class;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][$cacheKey]
    = ClassCacheManager::class . '->reBuild';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][]
    = ProcessDataMap::class;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['sit'][] = 'SJBR\\StaticInfoTables\\ViewHelpers';
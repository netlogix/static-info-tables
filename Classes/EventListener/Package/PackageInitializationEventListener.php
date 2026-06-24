<?php
namespace SJBR\StaticInfoTables\EventListener\Package;

/*
 *  Copyright notice
 *
 *  (c) 2022-2024 Stanislas Rolland <typo3AAAA(arobas)sjbr.ca>
 *  All rights reserved
 *
 *  This script is part of the Typo3 project. The Typo3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 */

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Package\Event\PackageInitializationEvent;
use TYPO3\CMS\Core\Package\Initialization\ImportStaticSqlDataOnPackageInitialization;
use TYPO3\CMS\Core\Utility\PathUtility;

/*
 * PackageInitializationEvent event listener
 *
 * Run the update script after base data was re-imported
 */
class PackageInitializationEventListener extends AbstractPackageEventListener
{
    /**
     * If the installed extension is static_info_tables or a language pack, execute the update
     *
     * @param PackageInitializationEvent $event
     * @return void
     */
    #[AsEventListener(after: ImportStaticSqlDataOnPackageInitialization::class)]
    public function __invoke(PackageInitializationEvent $event): void
    {
        $extensionKey = $event->getExtensionKey();
        if (strpos($extensionKey, 'static_info_tables') === 0) {
            $extensionKeyParts = explode('_', $extensionKey);
            if (
                // Base extension
                (count($extensionKeyParts) === 3)
                // Language pack
                || (count($extensionKeyParts) === 4 && strlen($extensionKeyParts[3]) === 2)
                || (count($extensionKeyParts) === 5 && strlen($extensionKeyParts[3]) === 2 && strlen($extensionKeyParts[4]) === 2)
            ) {
                $this->executeUpdate();
            }
        }
    }
}
<?php

\Smichaelsen\Lawyergallery\Utility\Backend\FluidContentElement::addTyposcriptConstants();
\Smichaelsen\Lawyergallery\Utility\Backend\FluidContentElement::registerContentElement(
  'Lawyer Gallery',
  '
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.header;header,
  --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.images,
    image,
  --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
    --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'Lawyer Gallery');

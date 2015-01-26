<?php
namespace Smichaelsen\Lawyergallery\Utility\Backend;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class FluidContentElement {

  /**
   * @var string
   */
  protected static $extKey = 'lawyergallery';

  /**
   * @param string $title
   * @param string $showItemList
   * @param bool $standardHeader
   */
  public static function registerContentElement($title, $showItemList = NULL, $standardHeader = TRUE) {
    $filename = str_replace(' ', '', $title);
    $typename = self::getPluginNamespace() . '_' . strtolower(str_replace(' ', '_', $title));

    // Frontend
    $setup = trim('
			tt_content.' . $typename . ' = COA
			tt_content.' . $typename . ' {
				' . ($standardHeader ? '10 = < lib.stdheader' : '') . '
				20 = FLUIDTEMPLATE
				20 {
					file = {$plugin.' . self::getPluginNamespace() . '.view.templateRootPath}' . $filename . '.html
					partialRootPath = {$plugin.' . self::getPluginNamespace() . '.view.partialRootPath}
					layoutRootPath = {$plugin.' . self::getPluginNamespace() . '.view.layoutRootPath}
				}
			}
		');
    ExtensionManagementUtility::addTypoScript(self::$extKey, 'setup', $setup, 'defaultContentRendering');

    // Backend
    ExtensionManagementUtility::addPlugin(
      array($title, $typename),
      'CType'
    );
    $pageTs = trim('
			mod.wizards.newContentElement.wizardItems {
				defaultContentElements.elements {
					' . $typename . ' {
						icon = ../typo3conf/ext/' . self::$extKey . '/Resources/Public/Icons/ContentElements/' . $filename . '.png
						title = ' . self::localLangPath($typename) . '.title
						description = ' . self::localLangPath($typename) . '.description
						tt_content_defValues {
							CType = ' . $typename . '
						}
					}
				}
			}
		');
    ExtensionManagementUtility::addPageTSConfig($pageTs);
    if (is_null($showItemList)) {
      $showItemList = $GLOBALS['TCA']['tt_content']['types']['textpic']['showitem'];
    }
    $GLOBALS['TCA']['tt_content']['types'][$typename]['showitem'] = $showItemList;
  }

  /**
   * @param string $title
   * @param string $additionalPageTs
   */
  public static function registerGridElement($title, $additionalPageTs = NULL, $includeAfterStatic = 'gridelements/Configuration/TypoScript/') {
    $filename = str_replace(' ', '', $title);
    $typename = self::getPluginNamespace() . '_' . strtolower(str_replace(' ', '_', $title));

    // Frontend
    $setup = trim('
				tt_content.gridelements_pi1.20.10.setup {
					# ' . $title . '
					' . $typename . ' < lib.gridelements.defaultGridSetup
					' . $typename . '.stdWrap.cObject.10.file = EXT:' . self::$extKey . '/Resources/Private/Fluid/GridElements/Templates/' . $filename . '.html
				}
		');
    ExtensionManagementUtility::addTypoScript(self::$extKey, 'setup', $setup, $includeAfterStatic);

    // Backend
    if (is_readable(ExtensionManagementUtility::extPath(self::$extKey) . 'Configuration/FlexForms/GridElements/' . $filename . '.xml')) {
      $flexformConfig = 'flexformDS = FILE:EXT:' . self::$extKey . '/Configuration/FlexForms/GridElements/' . $filename . '.xml';
    } else {
      $flexformConfig = '';
    }
    $pageTs = trim('
			tx_gridelements.setup.' . $typename . ' {
				icon = EXT:' . self::$extKey . '/Resources/Public/Icons/GridElements/' . $filename . '.png
				title = ' . self::localLangPath($typename) . '.title
				description = ' . self::localLangPath($typename) . '.description
				config {
					colCount = 1
					rowCount = 1
					rows {
						1 {
							columns {
								1 {
									name = ' . self::localLangPath($typename) . '.items
									colPos = 0
								}
							}
						}
					}
				}
				' . $flexformConfig . '
			}
		');
    ExtensionManagementUtility::addPageTSConfig($pageTs);
    if (!is_null($additionalPageTs)) {
      $additionalPageTs = trim('
				tx_gridelements.setup.' . $typename . ' {
					' . $additionalPageTs . '
				}
			');
      ExtensionManagementUtility::addPageTSConfig($additionalPageTs);
    }
  }

  /**
   *
   */
  public static function addTyposcriptConstants() {
    $constants = trim('
			plugin.' . self::getPluginNamespace() . '.view {
				templateRootPath = EXT:' . self::$extKey . '/Resources/Private/Fluid/ContentElements/
				partialRootPath = EXT:' . self::$extKey . '/Resources/Private/Fluid/ContentElements/Partials/
				layoutRootPath = EXT:' . self::$extKey . '/Resources/Private/Fluid/ContentElements/Layouts/
			}
		');
    ExtensionManagementUtility::addTypoScript(self::$extKey, 'constants', $constants);
  }

  /**
   * @param string $typename
   *
   * @return string
   */
  protected static function localLangPath($typename) {
    return 'LLL:EXT:' . self::$extKey . '/Resources/Private/Language/Backend/ContentElements.xlf:' . $typename;
  }

  /**
   * @return string
   */
  protected static function getPluginNamespace() {
    return 'tx_' . str_replace('_', '', self::$extKey);
  }

}

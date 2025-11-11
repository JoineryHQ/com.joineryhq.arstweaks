<?php

require_once 'arstweaks.civix.php';

use CRM_Arstweaks_ExtensionUtil as E;

/**
 * Implements hook_civicrm_pageRun().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_pageRun
 */
function arstweaks_civicrm_pageRun(&$page) {
  $pageName = $page->getVar('_name');
  if ($pageName == 'CRM_Contact_Page_View_UserDashBoard') {
    // Must add script file and vars here because it can't be  done from arstweaks_civicrm_alterContent().
    CRM_Core_Resources::singleton()->addScriptFile('com.joineryhq.arstweaks', 'js/CRM_Contact_Page_View_UserDashBoard.js', 100, 'page-footer');
  }
}


/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function arstweaks_civicrm_config(&$config): void {
  _arstweaks_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function arstweaks_civicrm_install(): void {
  _arstweaks_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function arstweaks_civicrm_enable(): void {
  _arstweaks_civix_civicrm_enable();
}

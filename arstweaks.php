<?php

require_once 'arstweaks.civix.php';

use CRM_Arstweaks_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function arstweaks_civicrm_config(&$config): void {
  _arstweaks_civix_civicrm_config($config);

  // This hook sometimes runs twice
  if (isset(Civi::$statics[__FUNCTION__])) {
    return;
  }
  Civi::$statics[__FUNCTION__] = 1;

  Civi::dispatcher()->addListener('civi.api.prepare', ['CRM_Arstweaks_APIWrapper', 'PREPARE'], -100);
  Civi::dispatcher()->addListener('civi.api.respond', ['CRM_Arstweaks_APIWrapper', 'RESPOND'], -100);
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

/**
 * Implements hook_civicrm_pageRun().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_pageRun
 */
function arstweaks_civicrm_pageRun(&$page) {
  $page_name = $page->getVar('_name');

  if ($page_name == 'CRM_Contact_Page_View_UserDashBoard') {
    // Special handling for various dashboard tabs (e.g. relationships)
    CRM_Core_Resources::singleton()->addScriptFile('com.joineryhq.arstweaks', 'js/CRM_Contact_Page_View_UserDashBoard.js', 100, 'page-footer');

    if (!CRM_Extension_System::singleton()->getManager()->isEnabled('certificates')) {
      // Don't have the certificates extension? Nothing to do here. Just return.
      return;
    }
    $contactId = $page->getVar('_contactId');
    if (!_arstweaksUserCanPrintCertificates($contactId)) {
      // User can't print certificates? Nothing to do here. Just return.
      return;
    }
    // get all current-status memberships for this contact.
    $currentMembershipIds = [];
    $memberships = \Civi\Api4\Membership::get(TRUE)
      ->addSelect('id')
      ->addWhere('status_id.is_current_member', '=', TRUE)
      ->addWhere('contact_id', '=', $contactId)
      ->execute();
    foreach ($memberships as $membership) {
      $currentMembershipIds[] = $membership['id'];
    }
    $vars = [
      'currentMembershipIds' => $currentMembershipIds,
      'contactId' => $contactId,
    ];
    CRM_Core_Resources::singleton()->addVars(E::SHORT_NAME, $vars);
  }
}

function _arstweaksUserCanPrintCertificates($contactId) {
  return (
    CRM_Core_Permission::check('download membership certificates')
    || (
      $contactId == CRM_Core_Session::getLoggedInContactID()
      && CRM_Core_Permission::check('download own certificate')
    )
  );
}

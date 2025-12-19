<?php

use CRM_Arstweaks_ExtensionUtil as E;

/**
 * Description of CRM_Stepw_APIWrapper
 *
 * @author as
 */
class CRM_Arstweaks_APIWrapper {

  /**
   * API wrapper for 'prepare' events; delegates to private static methods in this class.
   *
   * @param Civi\API\Event\PrepareEvent $event
   */
  public static function PREPARE(Civi\API\Event\PrepareEvent $event) {
    // Pass event to the PREPARE handler for this api request, if one exists in this class.
    $requestSignature = $event->getApiRequestSig();
    $methodName = 'PREPARE_' . str_replace('.', '_', $requestSignature);
    if (is_callable([self::class, $methodName])) {
      call_user_func_array([self::class, $methodName], [$event]);
    }
  }

  /**
   * API wrapper for 'respond' events; delegates to private static methods in this class.
   *
   * @param Civi\API\Event\RespondEvent $event
   */
  public static function RESPOND(Civi\API\Event\RespondEvent $event) {
    // Pass event to the RESPOND handler for this api request, if one exists in this class.
    $requestSignature = $event->getApiRequestSig();
    $methodName = 'RESPOND_' . str_replace('.', '_', $requestSignature);
    if (is_callable([self::class, $methodName])) {
      call_user_func_array([self::class, $methodName], [$event]);
    }
  }

  private static function PREPARE_4_contribution_get($event) {

    // Only on the user dashboard, alter the api request:
    //  - remove 'limit' from contribution.get, in order to list all contributions;
    //  - set 'where' to show only contribs with greater-than-zero amount.
    // As an extra safety measure (to avoid breaking some api call we haven't
    // anticipated), also check that we're filtering on a single contact_id (as
    // would be done on the user dashboard).
    if ($_REQUEST['q'] == 'civicrm/user') {
      $request = $event->getApiRequest();
      $params = $request->getParams();
      if ($params['where'][0][0] == 'contact_id') {
        // Show only greater-than-zero-dollar contribs.
        $params['where'][] = ['total_amount', '>', '0'];
        $request->setWhere($params['where']);

        // No limit (return all contribs).
        $request->setLimit(0);
      }
    }
  }

}

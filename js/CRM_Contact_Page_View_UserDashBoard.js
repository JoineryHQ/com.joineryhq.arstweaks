CRM.$(function($) {
  /*global CRM, ts */
  
  var certificateUrl;
  var membershipId;
  var contactId = CRM.vars.arstweaks.contactId;
  var buttonLabel = ts('Download membership card');
  for (i in CRM.vars.arstweaks.currentMembershipIds) {
    membershipId = CRM.vars.arstweaks.currentMembershipIds[i];
    certificateUrl = '/civicrm/certificates/membership/pdf?cid=' + contactId + '&mid=' + membershipId;
    
    // final 'buttons' td might be missing (e.g. if it would be empty), so create if necessary.
    if (!$('tr.crm-dashboard-civimember tr#row_' + membershipId + ' td.crm-active-membership-renew').length) {
      $('tr.crm-dashboard-civimember tr#row_' + membershipId).append('<td class="crm-active-membership-renew">');
    }
    $('tr.crm-dashboard-civimember tr#row_' + membershipId + ' td.crm-active-membership-renew').prepend('<a href="' + certificateUrl + '" class="button"><span class="nowrap">' + buttonLabel + '</span></a>');
  }
  return;
  /**
   * onChange handler for is_cdash checkbox.
   */
  var isCdashChange = function isCdashChange() {
    if (CRM.$('input#is_cdash').is(':checked')) {
      CRM.$('select#cdash_contact_type').closest('tr').show();
      CRM.$('input#is_show_pre_post').closest('tr').show();
      CRM.$('input#is_edit').closest('tr').show();
    }
    else {
      CRM.$('select#cdash_contact_type').closest('tr').hide();
      CRM.$('input#is_show_pre_post').closest('tr').hide();
      CRM.$('input#is_edit').closest('tr').hide();
    }
  };

  CRM.$('input#is_cdash').change(isCdashChange);
  isCdashChange();
});

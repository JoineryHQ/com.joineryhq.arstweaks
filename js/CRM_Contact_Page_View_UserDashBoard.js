CRM.$(function($) {
  /*global CRM, ts */
  
  var certificateUrl;
  var membershipId;
  var contactId = CRM.vars.arstweaks.contactId;
  var buttonLabel = ts('Download membership card');
  var buttonHtml;
  for (var i in CRM.vars.arstweaks.currentMembershipIds) {
    membershipId = CRM.vars.arstweaks.currentMembershipIds[i];
    certificateUrl = '/civicrm/certificates/membership/pdf?cid=' + contactId + '&mid=' + membershipId;
    
    // final 'buttons' td might be missing (e.g. if it would be empty), so create if necessary.
    if (!$('tr.crm-dashboard-civimember tr#row_' + membershipId + ' td.crm-active-membership-renew').length) {
      $('tr.crm-dashboard-civimember tr#row_' + membershipId).append('<td class="crm-active-membership-renew">');
    }
    buttonHtml = '<a href="' + certificateUrl + '" class="button"><span class="nowrap">' + buttonLabel + '</span></a>';
    $('tr.crm-dashboard-civimember tr#row_' + membershipId + ' td.crm-active-membership-renew').prepend(buttonHtml);
  }

});

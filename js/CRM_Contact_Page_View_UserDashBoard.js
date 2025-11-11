/*global CRM, ts */
CRM.$(function($) {
  var ajaxStop = function ajaxStop() {
    // Tweak contents of the "Your Event(s)" section.
    $('.crm-dashboard-civievent .view-content tbody > tr').each(function(){
      // Remove link to event (in "Event" column)
      var eventTitle = $('> td:first-child a', this).text();
      if($('> td:first-child a', this).length) {
        $('> td:first-child', this).append('<span>' + eventTitle + '</span>').find('a:first-child').remove();
      }
    });
    // Also remove the description in this section, which tends to imply that the user
    // can "Click on the event name for more information."
    $('.crm-dashboard-civievent .view-content .description').hide();

    // Tweak contents of the "permissionedOrgs" (Relationships) secion:
    $('.crm-contact-relationship-user tbody > tr').each(function(){
      // Remove link to relationship (in "Relationship" column"), and
      // also remove link to related contact (in second column).
      var relText = $('> td:first-child a', this).text(),
          relOrgIcon = $('> td:nth-child(2) a:first-child', this).html(),
          relOrgText = $('> td:nth-child(2) a:nth-child(2)', this).text();
      if($('> td:first-child a', this).length) {
        $('> td:first-child', this).append('<span>' + relText + '</span>').find('a:first-child').remove();
        $('> td:nth-child(2)', this).append(relOrgIcon + '<span>' + relOrgText + '</span>').find('a').remove();
      }

      // Remove 'disable relationship' link
      $('> td:last-child a[title="Disable Relationship"]', this).remove();
      
      // Remove 'Edit Contact Information' link on individual contact rows.
      $('tr.crm-entity[data-entity="relationship"] a[title="Edit Contact Information"]').remove();
    });
  };
  
  var addMemberCardButtons = function addMemberCardButtons() {
    if ((!CRM.vars.arstweaks) || (!CRM.vars.arstweaks.contactId)) {
      // CRM.vars.arstweaks.contactId is defined when user has access to 'print memership card'.
      // If it's not defined, there's nothing to do here; just return.
      return;
    } 
    var contactId = CRM.vars.arstweaks.contactId;
    var certificateUrl;
    var membershipId;
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
  }
 
  // Execution begins here.
  $( document ).ajaxStop(ajaxStop);
  addMemberCardButtons();

});

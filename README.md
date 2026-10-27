# CiviCRM: ARS Tweaks

This is a custom CiviCRM extension with very specific features. If you're not already
using this extension, it may have no real value for you.

## Functionality

The following functions are provided by this extension:
- If the [Certificates](https://lab.civicrm.org/extensions/certificates) extension
  is enabled:
  - On the CiviCRM Contact Dashboard, in the Membership section, for all current-status
    memberships (if the user has permissions to print membership Certificates for the
    given contact) add a button labled "Download membership card" which links to the 
    Certificates URL to create a PDF membership card for that membership.
- On the CiviCRM Contact Dashboard:
  - In the Relationships section, hide links that might lead to CiviCRM (and other
    elements that might imply greater access than is actually available.)
  - In the Contributions section, hide zero-dollar contributions, and otherwise
    display all contributions (i.e., remove CiviCRM's limit of 12 in this section).
- Immediately after a new contact is created, that contact's External ID is populated
  with a string equivalent to the contact ID preceded by 'M'.
  NOTE: if a value for External Identifier is specified by the contact creation,
  (e.g. by a CSV import column or API parameter) the automatic value will not be
  applied.

## Configuration
This extension calls for no configuration. However, configurations and permissions for
the Certificates extension are relevant.

## Support

Support for this package is handled under Joinery's ["As-Is Support" policy](https://joineryhq.com/software-support-levels#as-is-support).

Public issue queue for this package: https://github.com/JoineryHQ/com.joineryhq.arstweaks/issues
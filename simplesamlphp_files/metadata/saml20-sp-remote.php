<?php

/**
 * SAML 2.0 remote SP metadata for SimpleSAMLphp.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-sp-remote
 */
$metadata['https://sts.co.washington.or.us/services/trust'] = array (
  'entityid' => 'https://sts.co.washington.or.us/services/trust',
  'contacts' => 
  array (
    0 => 
    array (
      'contactType' => 'support',
      'emailAddress' => 
      array (
        0 => '',
      ),
      'telephoneNumber' => 
      array (
        0 => '',
      ),
    ),
  ),
  'metadata-set' => 'saml20-sp-remote',
  'AssertionConsumerService' => 
  array (
    0 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://sts.co.washington.or.us/adfs/ls/',
      'index' => 0,
      'isDefault' => true,
    ),
    1 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Artifact',
      'Location' => 'https://sts.co.washington.or.us/adfs/ls/',
      'index' => 1,
    ),
    2 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://sts.co.washington.or.us/adfs/ls/',
      'index' => 2,
    ),
  ),
  'SingleLogoutService' => 
  array (
    0 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect',
      'Location' => 'https://sts.co.washington.or.us/adfs/ls/',
    ),
    1 => 
    array (
      'Binding' => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
      'Location' => 'https://sts.co.washington.or.us/adfs/ls/',
    ),
  ),
  'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
  'keys' => 
  array (
    0 => 
    array (
      'encryption' => true,
      'signing' => false,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIC8DCCAdigAwIBAgIQcq/yXJy5paxAw8nGVwFW3jANBgkqhkiG9w0BAQsFADA0MTIwMAYDVQQDEylBREZTIEVuY3J5cHRpb24gLSBzdHMuY28ud2FzaGluZ3Rvbi5vci51czAeFw0yMTA0MDUyMjUxNTlaFw0yMjA0MDUyMjUxNTlaMDQxMjAwBgNVBAMTKUFERlMgRW5jcnlwdGlvbiAtIHN0cy5jby53YXNoaW5ndG9uLm9yLnVzMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA2kxSjjw9dHVZB3lVmIHtkJv5Awcys+kW6X9unR1pOqe+bTXpL32r40HH1ycJpMDjnCq4UymmSkvQKAgPBQSFbrM1XGEIq4J/rY/4LKOHB+SlqJoCoqmr8yI8p/kjMrWpGTnxRLj7e2kUI0O2//j3DBm2jHo7SiWsxZhHE2Is0FvRKiN6Fxmlj80sx1/B/BBPXPLizYU1UI/8m5D5nCF5b9CFdWesib4QnWvc+WnxI0Mm70zTuHcFUPeEttdzPEKXFn+InFSKEIZSZGApfYXaDmF4g92Q2Vn0ZwACIkbOXF1R5Ye6ILXXTz6AOfCotwYd2Ss6VuTN1gAFvkVZNVCprwIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQC0UHLAy0KFwUbODScRyyY8ujn2OetS2KYNLjLKsjh60N8oOu6azcJaqPlDHyfBAwgqey4XABL5uA5qyQ0qmwdKKrcmeD5HXxcDDSP6gxgg49kpeeMMHsz55b4wtXDG5ulktB9VYjnfsK5SMR4lsiswC3txMUJdrhe2QCEVcSCFOjPuD6cxn7JELf+Bjfva1kQemBAMnAyWer6G1zoUedvrBUDN8FUqWvqarjj4FpnZwlSl0hz/cPuz9Or8ssM9xTvubVGmu7PKYu+XXBB4VGp4ZYYmwCNafsPrFeBZ22N7LnpGdAfUWwUAPx5iimFqtXofTPxaAmkmpbLZfbBDEgqP',
    ),
    1 => 
    array (
      'encryption' => false,
      'signing' => true,
      'type' => 'X509Certificate',
      'X509Certificate' => 'MIIC6jCCAdKgAwIBAgIQMv1Hu+fcmotFLNGSz8L8NjANBgkqhkiG9w0BAQsFADAxMS8wLQYDVQQDEyZBREZTIFNpZ25pbmcgLSBzdHMuY28ud2FzaGluZ3Rvbi5vci51czAeFw0yMTA0MDUyMjUyMTBaFw0yMjA0MDUyMjUyMTBaMDExLzAtBgNVBAMTJkFERlMgU2lnbmluZyAtIHN0cy5jby53YXNoaW5ndG9uLm9yLnVzMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4YreHbDt7fUZ3+GFEXiOBloUBjSDGC7y7CJZlYi2lYWw+kloYWBY7y3r79LlU6JCOpHbBSz6O6pvU7CyL2+pD8kHGmCb1mQAii1N8kdUML0wLkyjaggP/uvj/4lNasBHrfW8A9d1Th2WTNJtOUaS6weD5IkOl6awLRdMaMwuOSG4/DhhlodG3TNppkRtg5hBm1i0B3yQoaGIOgBVR7VJz88NqwpGuhyLnospLO9cgx5Wyzf7jjyQeDOPfbq//7U/UW+ZdDZvEAtPSzmIZ/buop+szJCFzVyT6gAV3T32FaXQuDtRAlAzmJ4rY0VFuPeeAbPYI0xRivi15UW5P5a6OQIDAQABMA0GCSqGSIb3DQEBCwUAA4IBAQBm7iOyxoNYl/H+FECr/3vU/cwO3qD0+hZjsoOhyHi0NkDIquglw4F0dXi4Z+8VN3XEgCFo4jfv/jlv7+LpHoOFyIsnVkhRAFaIRR8YWndcRfExeaKG2y9fKtQfuxpRWq5Ky9kIhDOiX65LL4OM4z0+Jqh1tey6x/5/L6JhchFjKTL4v1tNRa/EJHkvuiPiBXioqkH6NmyZT74onT4cYN+Vngt1+KLUMz9SvXYLcOPYnsV81Uod8Xgl6Nw/mt7KfG4IIKy1AzrLhmFQYWEVvib4ma2jaBs/dV3Xj1EbG7iIqgQjdGD+YQ0av6b8QweJQhoAiq1735p68OaFV08iXJgB',
    ),
  ),
  'saml20.sign.assertion' => true,
);


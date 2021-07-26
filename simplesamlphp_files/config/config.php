<?php

use SimpleSAML\Logger;

$config = [];

/*
   * Perform any global overrides
   */

$config['technicalcontact_name'] = "Washington County Webteam";
$config['technicalcontact_email'] = "webteam@co.washington.or.us";

$config['admin.protectindexpage'] = TRUE;

$samlfiles = __DIR__ . '/../';
$acpdir = sprintf('/mnt/files/%s.%s/', $_ENV['AH_SITE_GROUP'], $_ENV['AH_SITE_ENVIRONMENT']);

$config['metadatadir'] = $samlfiles . 'metadata/';
$config['certdir']     = $acpdir . 'cert/';

$config['enable.saml20-idp'] = TRUE;

$secrets_file = $acpdir . 'secrets.settings.php';
if (file_exists($secrets_file)) {
  require $secrets_file;
}

$protocol = 'https://';
$port = '443';
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $_SERVER['SERVER_PORT'] = 443;
  $_SERVER['HTTPS'] = 'true';
  $protocol = 'https://';
  $port = $_SERVER['SERVER_PORT'];
}
$config['baseurlpath'] = $protocol . $_SERVER['HTTP_HOST'] . ':' . $port . '/simplesaml/';
$config['trusted.url.domains'] = [$_SERVER['HTTP_HOST']];

/*
   * Perform any local only overrides
   */
if (file_exists($samlfiles . 'config.local.php')) {
  // Instead of adding all the local configuration, include a file that can be added to .gitignore
  include 'config.local.php';
}

if (isset($_ENV['AH_SITE_ENVIRONMENT'])) {

  if ($_ENV['AH_SITE_ENVIRONMENT'] === 'ide') {
    $config['store.type'] = 'sql';
    $config['store.sql.dsn'] = sprintf('mysql:host=%s;port=%s;dbname=%s', '127.0.0.1', '', 'drupal');
    $config['store.sql.username'] = 'drupal';
    $config['store.sql.password'] = 'drupal';
    $config['store.sql.prefix'] = 'simplesaml';
    $config['loggingdir'] = '/var/www/simplesamlphp/log/';
  } else {
    // Setup basic logging.
    $config['logging.handler'] = 'file';
    $config['loggingdir'] = dirname(getenv('ACQUIA_HOSTING_DRUPAL_LOG'));
    $config['logging.logfile'] = 'simplesamlphp-' . date('Ymd') . '.log';
    $creds_json = file_get_contents('/var/www/site-php/' . $_ENV['AH_SITE_GROUP'] . '.' . $_ENV['AH_SITE_ENVIRONMENT'] . '/creds.json');
    $databases = json_decode($creds_json, TRUE);
    $creds = $databases['databases'][$_ENV['AH_SITE_GROUP']];
    require_once "/usr/share/php/Net/DNS2_wrapper.php";
    try {
      $resolver = new Net_DNS2_Resolver(array(
        'nameservers' => array(
          '127.0.0.1',
          'dns-master',
        ),
      ));
      $response = $resolver->query("cluster-{$creds['db_cluster_id']}.mysql", 'CNAME');
      $creds['host'] = $response->answer[0]->cname;
    } catch (Net_DNS2_Exception $e) {
      $creds['host'] = "";
    }
    $config['store.type'] = 'sql';
    $config['store.sql.dsn'] = sprintf('mysql:host=%s;port=%s;dbname=%s', $creds['host'], $creds['port'], $creds['name']);
    $config['store.sql.username'] = $creds['user'];
    $config['store.sql.password'] = $creds['pass'];
    $config['store.sql.prefix'] = 'simplesaml';
  }
}


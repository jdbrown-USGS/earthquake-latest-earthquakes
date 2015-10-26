<?php

date_default_timezone_set('UTC');

// work from lib directory
chdir(dirname($argv[0]));

if (isset($_SERVER['PWD'])) {
  // pwd doesn't resolve symlinks
  $LIB_DIR = $_SERVER['PWD'];
} else {
  // windows doesn't provide $_SERVER['PWD']...
  $LIB_DIR = getcwd();
}
$APP_DIR = dirname($LIB_DIR);
$HTDOCS_DIR = $APP_DIR . DIRECTORY_SEPARATOR . 'htdocs';
$CONF_DIR = $APP_DIR . DIRECTORY_SEPARATOR . 'conf';
$HTTPD_CONF = $CONF_DIR . DIRECTORY_SEPARATOR . 'httpd.conf';


// create conf directory if it doesn't exist
if (!is_dir($CONF_DIR)) {
  mkdir($CONF_DIR, 0755, true /*recursive*/);
}

// write apache configuration
file_put_contents($HTTPD_CONF, '
  ## autogenerated at ' . date('r') . '


  # alias for application
  Alias /earthquakes/map ' . $HTDOCS_DIR . '


  # allow requests, and set default caching
  <Location /earthquakes/map>
    Order Allow,Deny
    Allow From all

    ExpiresActive on
    ExpiresDefault "access plus 1 days"
  </Location>
');

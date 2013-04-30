<?php
/**
 * @version $Id: config.php 7396 2010-03-25 18:07:34Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */
define('DEFAULT_DBTYPE', 'mysql');
// CHANGE BACK
define('DEFAULT_DBUSER', 'phpwebsite');
define('DEFAULT_DBHOST', 'localhost');
define('DEFAULT_DBPORT', NULL);
define('DEFAULT_DBNAME', 'phpwebsite');

define('CHECK_DB_CONNECTION', TRUE);

// Set this value to false to disable auto forwarding during installation.
define('AUTO_FORWARD', true);

?>
<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: index.php 7776 2010-06-11 13:52:58Z jtickle $
 */

if (!defined('PHPWS_SOURCE_DIR')) {
    exit();
}

PHPWS_Core::initModClass('signup', 'Signup.php');
$signup = new Signup;
if (isset($_REQUEST['aop'])) {
    $signup->adminMenu();
} elseif (isset($_REQUEST['uop'])) {
    $signup->userMenu();
} elseif (isset($_REQUEST['sheet_id'])) {
    $signup->userMenu('signup_sheet');
} else {
    PHPWS_Core::home();
}

?>
<?php

/**
 * @version $Id: index.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

if (!defined('PHPWS_SOURCE_DIR')) {
    header('location: ../../index.php');
    exit();
}

PHPWS_Core::initModClass('alert', 'Alert.php');
$alert = new Alert;

if (isset($_REQUEST['aop'])) {
    $alert->admin();
} else {
    $alert->user();
}

?>
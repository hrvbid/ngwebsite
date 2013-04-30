<?php

/**
 * Steering file
 *
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: index.php 7776 2010-06-11 13:52:58Z jtickle $
 */

if (!defined('PHPWS_SOURCE_DIR')) {
    include '../../core/conf/404.html';
    exit();
}

if (isset($_REQUEST['tab']) || isset($_REQUEST['command'])) {
    PHPWS_Core::initModClass('search', 'Admin.php');
    Search_Admin::main();
} else {
    Search_User::main();
}

?>
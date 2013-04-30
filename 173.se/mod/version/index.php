<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: index.php 7776 2010-06-11 13:52:58Z jtickle $
 */
if (!defined('PHPWS_SOURCE_DIR')) {
    include '../../core/conf/404.html';
    exit();
}

if (!Current_User::authorized('version')) {
    Current_User::disallow();
    return;
}

PHPWS_Core::initModClass('version', 'Admin.php');
Version_Admin::main();

?>
<?php
/**
 * @version $Id: index.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

if (!defined('PHPWS_SOURCE_DIR')) {
    include '../../core/conf/404.html';
    exit();
}

PHPWS_Core::initModClass('access', 'Access.php');
if (Current_User::authorized('access')) {
    Access::main();
} else {
    Current_User::disallow();
    exit();
}

?>
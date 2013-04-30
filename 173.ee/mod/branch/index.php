<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: index.php 7776 2010-06-11 13:52:58Z jtickle $
 */

if (!Current_User::authorized('branch')) {
    Current_User::disallow();
}

PHPWS_Core::initModClass('branch', 'Branch_Admin.php');
$branch_admin = new Branch_Admin;
$branch_admin->main();

?>
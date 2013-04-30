<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: close.php 7776 2010-06-11 13:52:58Z jtickle $
 */

PHPWS_Core::initModClass('search', 'User.php');

Search_User::searchBox();

if (isset($_SESSION['Search_Admin'])) {
    PHPWS_Core::initModClass('search', 'Admin.php');
    Search_Admin::miniAdmin();
}

?>
<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: close.php 7776 2010-06-11 13:52:58Z jtickle $
 */

if (Current_User::isLogged()) {
    PHPWS_Core::initModClass('notes', 'My_Page.php');

    Notes_My_Page::showUnread();

    $key = Key::getCurrent(false);
    if ($key) {
        Notes_My_Page::miniAdminLink($key);
        Notes_My_Page::showAssociations($key);
    }
}

?>
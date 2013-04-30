<?php

/**
 * Crutch display of old modules
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: close.php 7355 2010-03-16 20:44:17Z matt $
 */

if (Current_User::allow('layout')) {
    Layout::miniLinks();
}

Layout::keyDescriptions();
Layout::showKeyStyle();
if (defined('LAYOUT_CHECK_COOKIE') && LAYOUT_CHECK_COOKIE) {
    check_cookie();
}
echo Layout::display();
?>
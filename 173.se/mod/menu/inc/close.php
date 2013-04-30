<?php
/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: close.php 7856 2011-01-13 21:50:38Z matt $
 */

if (!defined('PHPWS_SOURCE_DIR')) {
    exit();
}

Menu::show();
Menu::showPinned();
Menu::miniadmin();
unset($GLOBALS['MENU_LINKS']);

?>
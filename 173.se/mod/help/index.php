<?php
/**
 * @version $Id: index.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

if (!defined('PHPWS_SOURCE_DIR')) {
    include '../../core/conf/404.html';
    exit();
}

PHPWS_Core::initModClass('help', 'Help.php');

PHPWS_Help::show_help();

?>
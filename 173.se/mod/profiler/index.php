<?php
/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: index.php 7776 2010-06-11 13:52:58Z jtickle $
 */

if (!defined('PHPWS_SOURCE_DIR')) {
    include '../../core/conf/404.html';
    exit();
}

if (isset($_REQUEST['user_cmd'])) {
    PHPWS_Core::initModClass('profiler', 'Profiler.php');
    Profiler::user();
} else {
    if (!Current_User::authorized('profiler')) {
        Current_User::disallow();
    }

    PHPWS_Core::initModClass('profiler', 'Profiler.php');
    Profiler::admin();
}

?>
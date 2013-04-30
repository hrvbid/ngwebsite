<?php

/**
 * @version $Id: close.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

if (PHPWS_Core::atHome() || isset($GLOBALS['comments_viewed'])) {
    $show_number = PHPWS_Settings::get('comments', 'recent_comments');
    if ($show_number) {
        PHPWS_Core::initModClass('comments', 'Comments.php');
        Comments::showRecentComments($show_number);
    }
}

?>
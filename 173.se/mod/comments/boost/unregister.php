<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: unregister.php 7776 2010-06-11 13:52:58Z jtickle $
 */

function comments_unregister($module, &$content)
{
    PHPWS_Core::initModClass('comments', 'Comments.php');
    $content[] = dgettext('comments', 'Removing module\'s comments.');
    if (Comments::unregister($module)) {
        $content[] = dgettext('comments', 'Comments (if any) removed successfully');
    } else {
        $content[] = dgettext('comments', 'An error occurred when trying to remove comments.');
    }

    return TRUE;
}

?>
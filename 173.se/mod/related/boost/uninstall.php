<?php

/**
 * @version $Id: uninstall.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

function related_uninstall(&$content)
{
    PHPWS_DB::dropTable('related_friends');
    PHPWS_DB::dropTable('related_main');
    $content[] = dgettext('related', 'Related tables removed.');
    return true;
}

?>
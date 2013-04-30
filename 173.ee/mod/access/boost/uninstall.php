<?php

/**
 * Uninstall file for access
 *
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: uninstall.php 7776 2010-06-11 13:52:58Z jtickle $
 */

function access_uninstall(&$content)
{
    PHPWS_DB::dropTable('access_shortcuts');
    PHPWS_DB::dropTable('access_allow_deny');
    $content[] = dgettext('access', 'Access tables removed.');
    return TRUE;
}

?>
<?php

/**
 * Uninstall file for block
 *
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: uninstall.php 7776 2010-06-11 13:52:58Z jtickle $
 */

function block_uninstall(&$content)
{
    PHPWS_DB::dropTable('block');
    PHPWS_DB::dropTable('block_pinned');
    $content[] = dgettext('block', 'Block tables removed.');
    return true;
}


?>

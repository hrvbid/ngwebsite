<?php
/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: uninstall.php 7776 2010-06-11 13:52:58Z jtickle $
 */

function demographics_uninstall(&$content)
{
    PHPWS_DB::dropTable('demographics');
    $content[] = dgettext('demographics', 'Demographics table removed.');
    return TRUE;
}

?>
<?php
/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: uninstall.php 7776 2010-06-11 13:52:58Z jtickle $
 */

function branch_uninstall(&$content)
{
    PHPWS_DB::dropTable('branch_sites');
    PHPWS_DB::dropTable('branch_mod_limit');
    return TRUE;
}


?>
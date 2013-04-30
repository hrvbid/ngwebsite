<?php
/**
 * @version $Id: uninstall.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

function signup_uninstall(&$content) {
    PHPWS_DB::dropTable('signup_sheet');
    PHPWS_DB::dropTable('signup_peeps');
    PHPWS_DB::dropTable('signup_slots');
    $content[] = dgettext('signup', 'Signup tables dropped.');
    return true;
}
?>
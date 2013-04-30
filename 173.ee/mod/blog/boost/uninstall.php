<?php

/**
 * Uninstall file for blog
 *
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: uninstall.php 7776 2010-06-11 13:52:58Z jtickle $
 */

function blog_uninstall(&$content)
{
    PHPWS_DB::dropTable('blog_entries');
    $content[] = dgettext('blog', 'Blog tables removed.');
    return TRUE;
}


?>

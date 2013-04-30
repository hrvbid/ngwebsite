<?php

/**
 * @version $Id: uninstall.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

function rss_uninstall()
{
    PHPWS_DB::dropTable('rss_channel');
    PHPWS_DB::dropTable('rss_feeds');
    return TRUE;
}

?>

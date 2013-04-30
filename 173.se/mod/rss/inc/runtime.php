<?php
/**
 * @version $Id: runtime.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

PHPWS_Core::initModClass('rss', 'RSS.php');

if (!isset($_REQUEST['module'])) {
    RSS::showFeeds();
}

?>
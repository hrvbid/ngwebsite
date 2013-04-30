<?php
/**
 *
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: register.php 7776 2010-06-11 13:52:58Z jtickle $
 */

function rss_register($module, &$content)
{
    PHPWS_Core::initModClass('rss', 'RSS.php');
    return RSS::registerModule($module, $content);
}

?>
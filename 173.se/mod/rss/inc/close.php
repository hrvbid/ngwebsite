<?php
/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: close.php 7776 2010-06-11 13:52:58Z jtickle $
 */
$key = Key::getCurrent();

if (empty($key) || $key->isDummy() || $key->restricted) {
    return;
}

PHPWS_Core::initModClass('rss', 'RSS.php');
RSS::showIcon($key);

?>
<?php
/**
 * @version $Id: init.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

PHPWS_Core::initModClass('block', 'Block.php');
require_once PHPWS_SOURCE_DIR . 'mod/block/inc/parse.php';
PHPWS_Text::addTag('block', 'view');

?>
<?php
/**
 * @version $Id: init.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */
if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'branch') {
    PHPWS_Core::initModClass('boost', 'Boost.php');
}
?>
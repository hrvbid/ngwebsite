<?php
/**
 * @version $Id: runtime.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

if (PHPWS_Core::atHome()) {
    PHPWS_Core::initModClass('alert', 'Alert.php');
    $alert = new Alert;
    $alert->viewItems();
}

?>
<?php
/**
 *
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: register.php 7776 2010-06-11 13:52:58Z jtickle $
 */

function controlpanel_register($module, &$content)
{
    PHPWS_Core::initModClass('controlpanel', 'ControlPanel.php');

    $result = PHPWS_ControlPanel::registerModule($module, $content);
    return $result;
}

?>
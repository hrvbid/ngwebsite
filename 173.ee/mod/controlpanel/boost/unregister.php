<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: unregister.php 7776 2010-06-11 13:52:58Z jtickle $
 */

function controlpanel_unregister($module, &$content)
{
    PHPWS_Core::initModClass('controlpanel', 'ControlPanel.php');
    return PHPWS_ControlPanel::unregisterModule($module, $content);
}
?>

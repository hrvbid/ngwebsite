<?php

/**
 * @version $Id: index.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at appstate dot edu>
 */


if (Current_User::allow('whodis')) {
    PHPWS_Core::initModClass('whodis', 'Whodis.php');
    Whodis::admin();
}

?>
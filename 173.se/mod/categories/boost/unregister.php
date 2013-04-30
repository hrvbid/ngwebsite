<?php

/**
 * @version $Id: unregister.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

function categories_unregister($module, &$content){
    PHPWS_Core::initModClass("categories", "Categories.php");

    Categories::removeModule($module);
}

?>
<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: runtime.php 7311 2010-03-10 13:21:15Z matt $
 */

if (!isset($_SESSION['Clipboard'])) {
    return;
}

Clipboard::show();

?>
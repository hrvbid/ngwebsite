<?php
/**
 * @version $Id: close.php 7547 2010-04-20 17:51:43Z matt $
 */

if (isset($_SESSION['Related_Bank'])) {
    $_SESSION['Related_Bank']->show();
} else {
    $related = new Related;
    $related->show();
}

?>
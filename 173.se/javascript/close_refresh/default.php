<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: default.php 7333 2010-03-15 19:46:44Z matt $
 */

$default['timeout'] = 0;
$default['refresh'] = 1;
$default['set_timeout'] = ' ';

if (isset($data['use_link'])) {
    unset($default['set_timeout']);
}

?>
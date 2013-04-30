<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: default.php 7319 2010-03-10 17:53:48Z matt $
 */

$data['uncheck_label'] = _('Uncheck all');
$data['check_label'] = _('Check all');

switch (@$data['type']) {
    case 'checkbox':
        $data['input_type'] = 'checkbox';
        break;
         
    default:
        $data['input_type'] = 'button';
        break;
}
?>
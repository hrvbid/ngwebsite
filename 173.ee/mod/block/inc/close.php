<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: close.php 8369 2012-10-31 19:37:04Z matt $
 */

Block::show();

if (Current_User::allow('block')) {
    $key = Key::getCurrent();
    if (Key::checkKey($key) && javascriptEnabled()) {
        $val['address'] = sprintf('index.php?module=block&action=js_block_edit&key_id=%s&authkey=%s',
        $key->id, Current_User::getAuthkey());
        $val['label'] = dgettext('block', 'Add block here');
        $val['width'] = 750;
        $val['height'] = 650;
        MiniAdmin::add('block', javascript('open_window', $val));
    }
}

?>

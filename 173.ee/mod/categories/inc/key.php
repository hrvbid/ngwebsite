<?php

/**
 * unregisters deleted keys from categories
 *
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: key.php 7776 2010-06-11 13:52:58Z jtickle $
 */


function categories_unregister_key(&$key)
{
    if (empty($key) || empty($key->id)) {
        return FALSE;
    }

    $db = new PHPWS_DB('category_items');
    $db->addWhere('key_id', (int)$key->id);
    return $db->delete();
}

?>
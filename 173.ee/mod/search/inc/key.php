<?php

/**
 * unregisters deleted keys from search
 *
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: key.php 7776 2010-06-11 13:52:58Z jtickle $
 */


function search_unregister_key(Key $key)
{
    if (empty($key->id)) {
        return FALSE;
    }

    $db = new PHPWS_DB('search');
    $db->addWhere('key_id', (int)$key->id);
    return $db->delete();
}

?>
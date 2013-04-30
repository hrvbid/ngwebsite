<?php

/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: update.php 8294 2012-08-20 15:12:44Z matt $
 */


function cycle_update(&$content, $currentVersion)
{
    switch ($currentVersion) {
        case version_compare($currentVersion, '1.0.1', '<'):
            $content[] = '<pre>1.0.1 changes
-------------
+ Bug fixes
</pre>';
    }
    return TRUE;
}

?>
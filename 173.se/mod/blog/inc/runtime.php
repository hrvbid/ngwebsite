<?php
/**
 * @version $Id: runtime.php 7776 2010-06-11 13:52:58Z jtickle $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */


if (PHPWS_Settings::get('blog', 'home_page_display')) {
    if (!isset($_REQUEST['module'])) {
        $content = Blog_User::show();
        Layout::add($content, 'blog', 'view', TRUE);
    }
} else {
    Blog_User::showSide();
}

?>
<?php
/**
 * @author Matthew McNaney <mcnaney at gmail dot com>
 * @version $Id: my_page.php 7776 2010-06-11 13:52:58Z jtickle $
 */


function my_page()
{
    PHPWS_Core::initModClass('comments', 'My_Page.php');
    $content = Comments_My_Page::main();
    return $content;
}

?>
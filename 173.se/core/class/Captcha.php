<?php
/**
 * Small class that assists in loading CAPTCHA routines
 *
 * @version $Id: Captcha.php 7796 2010-08-19 18:44:58Z matt $
 * @author Matthew McNaney <mcnaney at gmail dot com>
 */

if (!defined('CAPTCHA_NAME')) {
    define('CAPTCHA_NAME', '');
}

class Captcha {

    public static function get()
    {
        $dirname = 'captcha/' . CAPTCHA_NAME . '/';

        if (is_dir(PHPWS_SOURCE_DIR . 'javascript/' . $dirname)) {
            return javascript($dirname);
        } else {
            return null;
        }
    }

    public static function verify($return_value=false)
    {
        $file = PHPWS_SOURCE_DIR . 'javascript/captcha/' . CAPTCHA_NAME . '/verify.php';

        if (!is_file($file)) {
            return true;
        }

        include $file;

        if (!function_exists('verify')) {
            return false;
        }

        return verify($return_value);
    }

    public static function isGD()
    {
        return extension_loaded('gd');
    }

}
?>
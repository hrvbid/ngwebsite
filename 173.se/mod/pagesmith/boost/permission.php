<?php
  /**
   * @author Matthew McNaney <mcnaney at gmail dot com>
   * @version $Id: permission.php 6614 2009-01-27 20:46:57Z matt $
   */

$use_permissions  = true;
$item_permissions = true;

$permissions['edit_page']   = dgettext('pagesmith', 'Edit page');
$permissions['delete_page'] = dgettext('pagesmith', 'Delete page');
$permissions['settings'] = dgettext('pagesmith', 'Change settings (Unrestricted only)');
$permissions['upload_templates'] = dgettext('pagesmith', 'Upload templates (Unrestricted only)');

?>
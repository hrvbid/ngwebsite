<?php

	$ngcom = new ngACo;
	$ngcom->vshrSetNode('ncl',array('authkey'=>Current_User::getAuthKey(),'httpsrc'=>PHPWS_SOURCE_HTTP));
	
	// templated (legacy) cle use
	$data['TYPE_TITLE']   = dgettext('core', 'Type');
	$data['FOLDER_TITLE'] = dgettext('core', 'Folder');
	$data['FILES_TITLE']  = dgettext('core', 'File');
	
	$data['MOD'] = PHPWS_Core::getCurrentModule();
	
	$ngcom->vi18nSetMsg('ncl',array('t001'=>$data['TYPE_TITLE'],
									't002'=>$data['FOLDER_TITLE'],
									't003'=>$data['FILES_TITLE'],
									't010'=>dgettext('core', 'no folder/file preset to insert')
									));
	javascript('jquery');
	javascript('jquery_ui');
	javascript('ng_com');

?>
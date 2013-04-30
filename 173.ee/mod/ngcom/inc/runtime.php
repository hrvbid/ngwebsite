<?php

	// ngcom load js to all ng mods and display i18n box

	javascript('jquery');
	javascript('ng_com');
	Layout::addStyle(NGCOM,'style.css');
	ngACo::vshrSetNode('ngcomvshr',array('httpsrc'=>PHPWS_SOURCE_HTTP, 'httpurl'=>PHPWS_HOME_HTTP));
	$i18n = new ngUCo;
	$i18n->showLangs();

?>
<?php

	function ngcom_update(&$content, $currentVersion)
	{
		$tf=true;
		if (!isset($_SESSION['ngboost']) or !array_key_exists('ml',$_SESSION['ngboost'])) {
			$content[]='this update is only served by ngboost';
			$tf=false;
		} else {
			switch ($currentVersion) {
				case version_compare($currentVersion, '3.1.0', '<'):
					if (!PHPWS_Boost::inBranch()) {
						if (file_exists(PHPWS_SOURCE_DIR.'javascript/jquery_tab/')) {
							$content[] = 'cleanup';
							ngcom_rm(PHPWS_SOURCE_DIR.'javascript/jquery_tab', $content);
						}
				//		$content[]=implode('<br />',$_SESSION['ngboost']['ml']['ngblock']);
						$moin = PHPWS_Core::installModList();	// n=>modname
					
						if ($_SESSION['ngboost']['ml']['ngblock']['in']=='t'
						&&  version_compare($_SESSION['ngboost']['ml']['ngblock']['vdb'], '3.1.0', '<')) 
						{
							$content[]='module ngBlock 3.0.x is installed, please uninstall';
							$tf=false;
						} else {
							if (version_compare($_SESSION['ngboost']['ml']['ngblock']['vfs'], '3.1.0', '<'))
							{
								$content[]='module ngBlock 3.0.x cleanup';
								ngcom_rm(PHPWS_SOURCE_DIR.'mod/ngblock', $content);
							}
						}
					
						if ($_SESSION['ngboost']['ml']['ngmenu']['in']=='t'
						&&  version_compare($_SESSION['ngboost']['ml']['ngmenu']['vdb'], '3.1.0', '<')) 
						{
							$content[]='module ngMenu 3.0.x is installed, please uninstall';
							$tf=false;
						} else {
							if (version_compare($_SESSION['ngboost']['ml']['ngmenu']['vfs'], '3.1.0', '<'))
							{
								$content[]='module ngMenu 3.0.x cleanup';
								ngcom_rm(PHPWS_SOURCE_DIR.'mod/ngmenu', $content);
							}
						}
					}
					break;
			}
		}
		return $tf;
	}
	
	function ngcom_rm($dir, &$content)
	{
		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir),
						RecursiveIteratorIterator::CHILD_FIRST);
		foreach ($iterator as $path) {
			if ($path->isDir()) {
				$isdot=$path->getFilename();
				if ($isdot=='.' || $isdot=='..') continue;
				$content[]='purging ' . str_replace(PHPWS_SOURCE_DIR,'',$path->__toString());
				rmdir($path->__toString());
			} else {
				$content[]='purging ' . str_replace(PHPWS_SOURCE_DIR,'',$path->__toString());
				unlink($path->__toString());
			}
		}
		$content[]='purging ' . str_replace(PHPWS_SOURCE_DIR,'',$dir);
		$content[]='';
		@rmdir($dir);
	}
	
?>
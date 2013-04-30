<?php

	if (isset($_SESSION['ngmenu']['reset'])) {
		unset($_SESSION['ngmenu']['show']);
		unset($_SESSION['ngmenu']['reset']);
	}
		
	$url=str_replace(array('index.php',	'?', 'module=', '&','='),
					 array('',			'&', '',		'/','/'),
					 PHPWS_Core::getCurrentUrl());
	$akey=Current_User::getAuthKey();
		
	$menu2 = new ngMenu20;
		
	if (!isset($_SESSION['ngmenu']['show'])) {
		$menu2->getMenu();
		$_SESSION['ngmenu']['show']=$menu2->rsMenus;
	}
	
	$lang = ngUCo::getLanguage();
	$have='';
	$take=false;
	$jso=array();
	
	foreach ($_SESSION['ngmenu']['show'] as $n => $menu) {
		// order is mname asc, mlang desc
		if ($have===$menu['mname']) {
			// same mname but less significant LCs
			continue;
		}
		
		if ($menu['mlang']==$lang
			// exact 
		|| $menu['mlang']==substr($lang,0,2)	
			// generic
		|| $menu['mlang']=='')
			// universal
		{
			$take=true;
			$have=$menu['mname'];
		}
		
		if ($take) {
			$take = false; 
			if (($menu['mpublic']) || (!$menu['mpublic'] && $menu2->conuser)) {			
				if ($menu['mpinall']) {
					$take=true;
				} else {
					// &authkey= or /authkey/
					$pos=strpos($url,'authkey');
					if ($pos>0) {
						$url=substr($url,0,$pos - 1);
					}
					if ($menu['mpinpage']=='') {
						// implies front (with all) - reject
					} else {
						// pseudo front
						if (($menu['mpinpage']=='/' && $url=='')
						||  ($menu['mpinpage']==$url))
						{
							$take = true;
						}
					}
				}
			}
		}
		if ($take) {
			$jso[$n]['mname'] = $menu['mname'];
			$jso[$n]['mpinpoint'] = $menu['mpinpoint'];
			$jso[$n]['mlang'] = $menu['mlang'];
			$menu2->rsMenu = $menu;
			$menu2->mname = $menu['mname'];
			$menu2->mvertical = $menu['mvertical'];
			$menu2->feedBox(str_replace('/authkey/', '/authkey/'.$akey, html_entity_decode(urldecode($menu['mdst']))),
							false,'ngmenucnt'.$menu['mname']);
			$take = false;
		}
	}
	// tao
	ngACo::vpoolSetNode('nmu',array('mod'=>'ngmenu'),$jso);
	ngACo::vshrSetNode('nmu',array('authkey'=>Current_User::getAuthKey()));
	
?>

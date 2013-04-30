<?php

	if (isset($_SESSION['ngblock']['reset'])) {
		unset($_SESSION['ngblock']['show']);
		unset($_SESSION['ngblock']['reset']);
	}
		
	$url=ltrim(str_replace(array('index.php',	'?', 'module=', '&','='),
					 				 array('',					'&', 	'',				'/','/'),
					 PHPWS_Core::getCurrentUrl()),
					 '/');
	$akey=Current_User::getAuthKey();
		
	$block2 = new ngBlock20;
		
	if (!isset($_SESSION['ngblock']['show'])) {
		$block2->getBlock();
		$_SESSION['ngblock']['show']=$block2->rsBlocks;
	}
	
	$lang = ngUCo::getLanguage();
	$have='';
	$take=false;
	$jso=array();
	
	foreach ($_SESSION['ngblock']['show'] as $n => $block) {
		// order is bname asc, blang desc
		if ($have==$block['bname']) {
			// same bname but less significant LCs
			continue;
		}
		
		if ($block['blang']==$lang
			// exact 
		|| $block['blang']==substr($lang,0,2)	
			// generic
		|| $block['blang']=='')
			// universal
		{
			$take=true;
			$have=$block['bname'];
		}
		
		if ($take) {
			$take = false; 
			if (($block['bpublic']) || (!$block['bpublic'] && $block2->conuser)) {
				if ($block['bpinall']) {
					$take=true;
				} else {
					// &authkey= or /authkey/
					$pos=strpos($url,'authkey');
					if ($pos>0) {
						$url=substr($url,0,$pos - 1);
					}
					if ($block['bpinpage']=='') {
						// implies front (with all) - reject
					} else {
						if ($block['bpinpage']=='/' && $url=='') {
							// alias front
							$take=true;
						} else {
							if ($block['bpinpage']==$url) {
								// exact
								$take = true;
							} else {
								// generic
								$ppge = explode('*',$block['bpinpage']);
								$ppct = count($ppge);
								if ($ppct>1) {
									$rpct='';
									str_replace($ppge,'',$url,$rpct);
									if (($ppct-1)===$rpct) {
										$take=true;
									}
								}
							}
						}
					}
				}
			}
		}
		if ($take) {
			$jso[$n]['bname'] = $block['bname'];
			$jso[$n]['bpinpoint'] = $block['bpinpoint'];
			$jso[$n]['blang'] = $block['blang'];
			$block2->rsBlock = $block;
			$block2->feedBlock();
			$take = false;
		}
	}
	
	// rt before ina fg
	$_SESSION['ngblock']['jso']=$jso;
	// tao
	ngACo::vpoolSetNode('nbk',array('mod'=>'ngblock'),$jso);
	ngACo::vshrSetNode('nbk',array('authkey'=>Current_User::getAuthKey()));
	// (httpsrc done by ngcom self)
	
?>

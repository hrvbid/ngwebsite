<?php

  class ngUCo {
  
	const IMGSRC = 'mod/ngcom/img/';

	var $context = '';
	var $conuser = '';
	var $me = false;
	var $msg = '';

    public function __construct()
	{
		if (defined('NGCOM')) {
			$this->context=PHPWS_Core::getCurrentModule();
			$this->conuser=Current_user::isLogged();
			if (isset($_SESSION[NGCOM]['msg.uco'])) {
				$this->msg=$_SESSION[NGCOM]['msg.uco'];
				unset($_SESSION[NGCOM]['msg.uco']);
			}
			$this->me=true;
		}
	}

	public function index($xop)
	{
		// FG
		// todo xop op
	//	$op = $this->vrq('op');
		switch ($xop) {
			case 'cfg':
					$this->i18nwop();
				break;
			case 'cfgset':
					$this->i18nmake();
				break;
		}
	}

	public function i18nwop() 
	{
		if ($this->context==NGCOM) {
			if ($this->conuser) {
				if (Current_User::allow(NGCOM, 'edit')) {
					$cnt='';
					$langs=$this->getAllLanguages();
					$chkf=$chkh=$chkn='';
					$jso=$this->_ngI18nCfg();
					if (isset($jso['style'])) {
						// fixed (static)
						$chkf=$jso['style']=='f'?' checked="checked"':'';
						// hover
						$chkh=$jso['style']=='h'?' checked="checked"':'';
						// nondisplay
						$chkn=$jso['style']=='n'?' checked="checked"':'';
					}
					$cnt.='<form id="ncouform" class="phpws-form form-protected" method="post" action="ngcom/op/i18n.cfgset">'
					.	'<table>'					
					.	'<tr><td colspan="3"  style="text-align:right;"><label class="radio-label">'
					.	gettext('i18n box').':</label></td><td>'
					.	'<input id="ngcoutplhov" type="radio" value="h" title="i18n Hover Style" name="ngibstyle" '.$chkh.' />'
					.	'<label class="radio-label">hover</label>&nbsp;'
					.	'<input id="ngcoutplfix" type="radio" value="f" title="i18n Fixed Style" name="ngibstyle" '.$chkf.' />'
					.	'<label class="radio-label">static</label>&nbsp;'
					.	'<input id="ngcoutplnon" type="radio" value="n" title="i18n Non Display" name="ngibstyle" '.$chkn.' />'
					.	'<label class="radio-label">none</label>'
					.	'</td></tr>'
					.	'<tr><td colspan="3" style="text-align:right;"><label>'.gettext('Pinpoint').':</label></td><td>'
					.	'<input type="text" maxlength="32" name="peg" value="'.(isset($jso['peg'])?$jso['peg']:'').'" title="'
					.	gettext('An optional peg (id or class) [#|.]+[a-z0-9][-]').'" /></td></tr>';
					$zebra='';
					foreach ($langs as $lc => $lang) {
						$zebra=='0'?$zebra='1':$zebra='0';
						$lcid=strtolower(str_replace('_','',$lc));
						$cnt.='<tr class="bgcolor'.$zebra.'"><td class="mono">'.$lc.'</td>'
						.	'<td><input type="checkbox" value="1" title="'.$lang.'"'
						.	' id="ncou'.$lcid.'" name="nglc'.$lcid.'"'
						.	(isset($jso['lc'][$lc])?' checked="checked" ':' ').'/></td>'
						.	'<td><img src="'.PHPWS_SOURCE_HTTP.self::IMGSRC.$lc.'.png" /></td>'
						.	'<td>'.$lang.'</td></tr>';					
					}
					$cnt.='</table>';
					$cnt.='<input type="submit" value="Save" id="phpws_form_make" name="make" />&nbsp;'
					.	  '<input type="submit" value="Cancel" id="phpws_form_cancel" name="cancel" />'
					.	  '&nbsp;<span class="msg">'.$this->msg.'&nbsp;</span>'
					.	  '</form>';
					$this->msg='';
					Layout::add($cnt);
				}
			} else {
				Current_User::requireLogin();
			}
		}
	}
	
	public function i18nmake() 
	{
		if ($this->context==NGCOM) {
			if ($this->conuser) {
				if (Current_User::allow(NGCOM, 'edit')) {
					if (isset($_REQUEST['make'])) {
						if ($_REQUEST['make']=='Save') {
							$jso=$this->_ngI18nCfg();
							if (isset($_REQUEST['ngibstyle'])) {
								if ($_REQUEST['ngibstyle']=='f' 
								||  $_REQUEST['ngibstyle']=='h'
								||  $_REQUEST['ngibstyle']=='n')
								{
									$jso['style']=$_REQUEST['ngibstyle'];
								}
							}
							if (isset($_REQUEST['peg'])) {
								if (preg_match('/^([\#\.])([0-9a-z\-])*$/',$_REQUEST['peg']) === 1
								or empty($_REQUEST['peg'])) {
									(string)$jso['peg']=$_REQUEST['peg'];
								}
							}	
							unset($jso['lc']);
							foreach ($_REQUEST as $k => $v) {
								if (substr($k,0,4)=='nglc' && $v=='1' && preg_match('/^[a-z]{8,8}$/',$k)===1) {
									$lc=substr($k,4,2).'_'.strtoupper(substr($k,6,2));
									$jso['lc'][$lc]=$v;
								}
							}
							$this->_ngI18nCfgSet($jso);
							$this->_ngI18nGo();
						}
					}
				}
			}
		}
	}

    public function _ngI18nCfg()
    {
		$mycfg='config/ngcom/ngi18n.jso';
		if (file_exists($mycfg)) {
			return json_decode(stripslashes(file_get_contents($mycfg)),true);
		} else {
			@mkdir('config/ngcom');
			file_put_contents($mycfg,json_encode(array()));
			return array();
		}
	}
    protected function _ngI18nCfgSet($jso)
    {
		if ($this->context==NGCOM) {
			if ($this->conuser) {
				if (Current_User::allow(NGCOM, 'edit')) {
					$cc=file_put_contents('config/ngcom/ngi18n.jso',addslashes(json_encode($jso)));
					$this->msg=gettext('saved').' ('.$cc.gettext(' bytes').')';
				}
			}
		}
	}
    protected function _ngI18nGo()
    {
		if ($this->context==NGCOM) {
			$_SESSION[NGCOM]['msg.uco']=$this->msg;
			header('Location: ngcom/op/i18n.cfg');
			//	PHPWS_Core::goBack();
		}
	}

	public function showLangs($langs=array()) {
		
		$jso=$this->_ngI18nCfg();
		
		if (isset($jso['style']) && $jso['style'] == 'n') return;
		
		// peg may be an id(#xxx) or a class(.xxx) or nothing
		$pinpoint = isset($jso['peg'])?' class="'.$jso['peg'].'"':'';
		
		$lx=$this->getAllLanguages();
		if (empty($jso)) {
			// no cfg
			if (empty($langs)) {
				$lcs=array_keys($lx);
			} else {
				$lcs=$langs;
			}
		} else {
			if (empty($jso['lc'])) {
				// nothing selected in cfg
				$lcs=array();
			} else {
				$lcs=array_keys($jso['lc']);
			}
		}
		if (isset($jso['style'])) {
			$style=$jso['style'];
		} else {
			$style='h';
		}
		$cnt='';
		switch ($style)
		{
			case 'f':
				foreach ($lcs as $lc) {
					$cc=strtoupper(substr($lc,0,2));
					if ($lc==$_COOKIE['phpws_default_language']) {
						$aadd = '<span class="a">';
						$aend = '</span>';
					} else {
						$aadd = '<a title="'.$lc.' '.$lx[$lc].'" onclick="tao.run.ngSetLocale(\''.$lc.'\')">';
						$aend = '</a>';
					}
					$cnt.='<td align="left">'.$aadd
						.'<img src="'.PHPWS_SOURCE_HTTP.self::IMGSRC.$lc.'.png" alt="'.$cc.'" />'
						.$cc.$aend.'&nbsp;</td>';
				}
				break;
			case 'h':
				$t=1;
				foreach ($lcs as $lc) {
					$cc=strtoupper(substr($lc,0,2));
					if ($t>4) {
						$cnt.='</tr><tr><td class="nglcs nglcstr">&nbsp;</td><td class="nglcs" align="left">';
						$t=2;
					} else {
						$cnt.='<td class="nglcs" align="left">';
						$t++;
					}
					if ($lc==$_COOKIE['phpws_default_language']) {
						$cnt.='<u><span id="nglci18ns">'
						.'<img src="'.PHPWS_SOURCE_HTTP.self::IMGSRC.$lc.'.png" alt="'.$cc.'" />'
						.$cc.'</span></u> ';
					} else {
						$cnt.='<a title="'.$lc.' '.$lx[$lc].'" onclick="tao.run.ngSetLocale(\''.$lc.'\')">'
						.'<img src="'.PHPWS_SOURCE_HTTP.self::IMGSRC.$lc.'.png" alt="'.$cc.'" />'
						.$cc.'</a> ';
					}
					$cnt.='&nbsp;</td>';
				}
			break;
		}
				
		$pre = '<div id="nglci18n"'.$pinpoint.'><table align="left" cellpadding="0" cellspacing="0"><tr><td>'
				. '<a id="nglci18na" title="default '.DEFAULT_LANGUAGE.' '.$lx[DEFAULT_LANGUAGE]
				. '" onclick="tao.run.ngSetLocale(\''.DEFAULT_LANGUAGE.'\')">'
				. '<img src="'.PHPWS_SOURCE_HTTP.'mod/ngcom/img/ww_WW.png" alt="&Phi;" />'
				. strtoupper(substr(DEFAULT_LANGUAGE,0,2)).'</a>&nbsp;&nbsp;&nbsp;'
				. '<span id="nglci18nc"></span></td>';
				
		$boxcnt=$pre.$cnt.'</tr></table></div>';
		// attention: moving i18nbox per layout to body prevents any body content else from display
		Layout::set($boxcnt,'nglocale','i18nbox');
	}
					
	public function getLanguage() {
		if (isset($_COOKIE['phpws_default_language'])) {
			$pair = $_COOKIE['phpws_default_language'];
			if (isset($pair)) {
				return $pair;
			}
		}
		// may be a very 1st time cleaned browser call
		ngUCo::setLanguage(CURRENT_LANGUAGE);
		return CURRENT_LANGUAGE;
	}

	public function setLanguage($pair) {
		$path=explode($_SERVER['HTTP_HOST'],PHPWS_HOME_HTTP);
		setcookie('phpws_default_language', $pair, mktime() + CORE_COOKIE_TIMEOUT, $path[1]);
	}

	public function getAllLanguages($generic=false) {
		$languages=array();
        $langfile = PHPWS_Core::getConfigFile('users', 'languages.php');
		if ($langfile) {
			include $langfile;
		}
		if ($generic) {
			if ($languages) {
				$shortlcs=array_keys($languages);
				$lca=array();
				foreach ($shortlcs as $lc) {
					$lca[substr($lc,0,2)]=substr($lc,0,2);
				}
				// expl de => de
				return $lca;
			}
		}
		// expl de_DE => German, ...
		return $languages;
	}

  }

?>
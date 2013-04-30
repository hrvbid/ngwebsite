<?php
/**
    * ngReadMe module for phpWebSite and ngWebSite
    *
    * Author: Hilmar Runge
    *
    * See docs/AUTHORS and docs/COPYRIGHT for relevant info.
    *
    * This program is free software; you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation; either version 2 of the License, or
    * (at your option) any later version.
    * 
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
    * 
    * You should have received a copy of the GNU General Public License
    * along with this program; if not, write to the Free Software
    * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
    *
*/
	// me 
	define (NGREADME,'ngreadme');
	define (NGREADMEMID,'nme');

class ngReadMe {

	/*
	 external op
		ngreadme					displays the modules list
		ngreadme/op/toc				displays the toc only
		ngreadme/op/m1/m/module		displays the module docs list
	 internal op
		ngreadme/op/see/r/itemid	displays search result doc		
	 */

	var $context = '';
	var $mods = array();
	var $kyitem='';
	var $kyref='';
	var $kyitemname='ReadmeFiles';
	var $kyobj=false;
	var $kyid=false;
	var $kywords=array();

    public function __construct()
	{
		$this->context=PHPWS_Core::getCurrentModule();
	}

	public function index() 
	{
		if (isset($_REQUEST['xaop'])) {
			$xaop=$_REQUEST['xaop'];
					isset($_REQUEST['x'])
					&& !empty($_REQUEST['x'])
					&& preg_match('/^[0-9a-z]*$/',$_REQUEST['x'])===1
					?$x=$_REQUEST['x']:$x=null;
			// BG		
			switch ($xaop) 
			{
				case '1a':
					$_SESSION['BG']=$this->reCode(
									   strip_tags(file_get_contents(
									   PHPWS_SOURCE_DIR.$_SESSION[NGREADME]['docs'][$x]),PHPWS_ALLOWED_TAGS
									   ));
					return;
					break;
				case '1b': case '1t':
					if (isset($_SESSION[NGREADME]['docs'][$x])) {
						$ngitem=strtr($_SESSION[NGREADME]['docs'][$x],'/',':');
						$tmp=explode(':',$ngitem);
						count($tmp)==2?$mod='':$mod=$tmp[1];
						$this->kysBix(':'.$ngitem,$mod);
						$this->_kysCountIx();
						if (isset($this->kywcount)) {
							$_SESSION['BG']=$this->kywcount;
						} else {
							$_SESSION['BG']='0';
						}	
					}
					return;
					break;
				case '1c':
					$ngitem=strtr($_SESSION[NGREADME]['docs'][$x],'/',':');
					$tmp=explode(':',$ngitem);
					count($tmp)==2?$mod='':$mod=$tmp[1];
					$doc=array_pop($tmp);
					$this->_kysGetKey($mod,$doc);
					if ($this->kyobj) {
						$this->_kysCountIx();
						if ($this->kywcount > 1) {
							$_SESSION['BG']=$this->kywords;
							return;
						}
					}
					$_SESSION['BG']='none';
					return;
					break;
				case '1d':
					$ngitem=strtr($_SESSION[NGREADME]['docs'][$x],'/',':');
					$tmp=explode(':',$ngitem);
					count($tmp)==2?$mod='':$mod=$tmp[1];
					$doc=array_pop($tmp);
					$this->kysDix(':'.$ngitem,$mod);
					$_SESSION['BG']=gettext('index purged');;
					return;
					break;
				default:
					exit;
			}
		}
		
		// FG
		isset($_REQUEST['op'])?$op=$_REQUEST['op']:$op=null;
		if (isset($_REQUEST['m'])
		&& preg_match('/^([a-z])*([0-9a-z])?$/',$_REQUEST['m'])===1) {
			$rqm=$_REQUEST['m'];
		} else {
			$rqm=null;
		}
		if (isset($_REQUEST['r'])
		&& preg_match('/^([0-9])?([0-9])*$/',$_REQUEST['r'])===1) {
			$rqr=$_REQUEST['r'];
		} else {
			$rqr=null;
		}

		switch ($op) 
		{
			case 'm1':
				$this->_readMods($rqm);
				$this->mList(false);
				break;
			case 'see':
				$this->kysShow($rqr);
				$this->tocOnly();
				break;
			case 'toc':
				$this->tocOnly();
				break;
			default:
				$this->_readMods();
				$this->mList(true);
				break;
		}
	}
	
	public function mList($all) 
	{
		if ($this->context==NGREADME) {
			$isdeity=Current_user::isDeity();
			$bixa=$jsoxref='';
			if ($all) {
				unset($_SESSION[NGREADME]['toc']);
				$title=gettext('Module List');
				if ($isdeity) {
					$bixa='<a onclick="nmeBixTotal()">reIndexAll</a><br />';
					$jsoxref='{';
				}
			} else {
				$title=gettext('Module Doc List');
			}
			$cnt='';
			$this->tocOnly();
			foreach ($this->mods as $mod=>$ar) {
				$cnt.='<div id="nmebxe'.$mod.'" class="nmebox">'
				.	'<b>'.$this->mods[$mod]['proname'].'</b>&nbsp;('.trim($mod.' '.$this->mods[$mod]['version'])
				.	')<br />'.($ar['cptxt']==''?'':$ar['cptxt'].'<br />')
				.	($ar['author']==''?'':'<i>'.$ar['author'].'</i><br />')
				.	$ar['abtxt'];
				if ($all) {
					$cnt.=gettext('Status').': '.count($this->mods[$mod]['docs'])
					.	' '.gettext('Docs included').', '
					.	PHPWS_Text::rewriteLink(gettext('more'), NGREADME, array('op'=>'m1', 'm'=>$mod))
					.	'&nbsp;<span id="nmebxa'.$mod.'">'.'</span><br />';
					if ($isdeity) {
						if (count($this->mods[$mod]['docs']) > 0) {
							$jsoxref.='"'.$mod.'":[';
							foreach ($this->mods[$mod]['docs'] as $n=>$doc) {
								$jsoxref.='"'.$this->mods[$mod]['xref'][$n].'",';
							}
							$jsoxref=substr($jsoxref,0,-1).'],';
						}
					}
				} else {
					$cnt.='<tt>'.gettext('Docs included').'</tt> ... ';
					if ($isdeity) {
						$docstr=implode('#',array_flip($this->mods[$mod]['docs']));
					}
					$mxref='';
					$cmt='';
					foreach ($this->mods[$mod]['docs'] as $n=>$doc) {
						$this->kywcount=0;
						$this->_kysGetKey($mod,$doc);
						$add='';
						if ($isdeity) {
							if ($this->kyobj) {
								$this->_kysCountIx();
								$add = '<span id="a'.$this->mods[$mod]['xref'][$n].'">&nbsp;( '
								.		gettext('File is indexed')
								.		', '.gettext('searchphrases found').': '.$this->kywcount
								.		'&nbsp;&nbsp;<a onclick="nmeTermsView('."'".$this->mods[$mod]['xref'][$n]."'"
								.		')">'.'showIndex</a>'
								.		'&nbsp;&nbsp;<a onclick="nmeBix('."'".$this->mods[$mod]['xref'][$n]."'".',0)">'
								.		'reIndex'.'</a>'
								.		'&nbsp;&nbsp;<a onclick="nmeDix('."'".$this->mods[$mod]['xref'][$n]."'".',0)">'
								.		'purgeIndex</a> ) </span>'
								.		'<span class="inmono" id="c'.$this->mods[$mod]['xref'][$n].'"></span>';
							} else {
								$add =	'&nbsp;&nbsp;( <a onclick="nmeBix('."'".$this->mods[$mod]['xref'][$n]."'".',0)">'
								.		'reIndex'.'</a> )'
								.		'<span id="a'.$this->mods[$mod]['xref'][$n].'">&nbsp;</span>';
							}
							$mxref.='<li>'.$this->mods[$mod]['xref'][$n].'</li>';
						}
						$cmt.='&nbsp;<a onclick="nmeDocDisplay('."'".$this->mods[$mod]['xref'][$n]."'".',0)">'
						.	  gettext('read').'</a>&nbsp;<tt>'.strtolower($doc).'</tt>'.$add
						.	  '<div id="d'.$this->mods[$mod]['xref'][$n].'"></div>';
					}
					if ($isdeity) {
						$cnt.='<a onclick="nmeBixAll()">&nbsp;reIndexAll</a>';
					}
					$cnt.='<br />'.$cmt.'<ul id="nmemxref" class="dark">'.$mxref.'</ul>';
				}
				$cnt.='</div>';
			}
		
			if ($all && $isdeity) {
				$jsoxref=substr($jsoxref,0,-1).'}';
				if (is_object(json_decode($jsoxref))) {
					$jsoxref='<div id="nmeaxref" class="dark">'.$jsoxref.'</div>';
				}
			}
			$this->feedContent($cnt.$bixa.$jsoxref,$title);
		}
	}
	
	public function tocOnly() {
		if ($this->context==NGREADME) {
			if (empty($this->mods)) {
				$this->_readMods();
				unset($_SESSION[NGREADME]['toc']);
			}
			if (isset($_SESSION[NGREADME]['toc'])) {
				$this->feedBox('ReadMe',$_SESSION[NGREADME]['toc']);
			} else {
				$_SESSION[NGREADME]['toc']=gettext('Display').' '.PHPWS_Text::rewriteLink(gettext('Module List').'<br /><br />',
						NGREADME, array('op'=>'toc').'<br />');
				foreach ($this->mods as $mod=>$ar) {
					$_SESSION[NGREADME]['toc'].=$mod.' '.PHPWS_Text::rewriteLink('<i>'.$this->mods[$mod]['proname'].'</i>',
						NGREADME, array('op'=>'m1', 'm'=>$mod)).'<br />';
				}
				$this->feedBox('ReadMe',$_SESSION[NGREADME]['toc']);
			}
		}
	}

	protected function feedBox($title,$text) 
	{
		if ($this->context==NGREADME) {
			Layout::addStyle(NGREADME,'style.css');
			$tpl['TITLE'] = $title;
			$tpl['CONTENT']=$text;
			$boxcnt=PHPWS_Template::process($tpl, NGREADME, 'toc.tpl');
			Layout::add($boxcnt,'','smallbox');
		}
	}

   	protected function feedContent($text,$title='') 
	{
		if ($this->context==NGREADME) {
			javascriptMod('ngreadme', 'ngreadme');
			Layout::addStyle(NGREADME,'style.css');
			$boxtpl['TITLE'] = $title;
			$boxtpl['CONTENT'] = $text;
			$content=PHPWS_Template::process($boxtpl, NGREADME, 'modbox.tpl');
			Layout::add($content);
		}
	}
	

	protected function _readMods($rqmod=false) 
	{
		// reads module list
		if ($this->context==NGREADME) {
		
			unset($_SESSION[NGREADME]['docs']);
			
			if ($rqmod===false || $rqmod=='') {
				$this->mods=array(''=>'');
			} else {
				$this->mods=array();
			}
			$path=PHPWS_SOURCE_DIR.'mod';
			$dir=opendir($path);
			// catch all existing mods 
			while (FALSE !== ($file = readdir ($dir))) {
				if ($file != '.' and $file != '..') {
					if (($rqmod && $rqmod==$file) || $rqmod===false) {
						$this->mods[$file]='';
					}
				}
			}
			closedir($dir);
			foreach ($this->mods as $mod=>$no) {
				if ($mod==='') {
					$cp=PHPWS_SOURCE_DIR.'core/boost/';
					$dp=PHPWS_SOURCE_DIR.'docs/';
				} else {
					$cp=$path.'/'.$mod.'/boost/';
					$dp=$path.'/'.$mod.'/docs/';
				}
				$link=array();
				if (file_exists($cp.'controlpanel.php')) {
					include $cp.'controlpanel.php';
					$this->mods[$mod]['cptxt']=$link[0]['description'];
				} else {
					$this->mods[$mod]['cptxt']='';
				}
				if (file_exists($cp.'boost.php')) {
					include $cp.'boost.php';
					$this->mods[$mod]['version']=$version;
					$this->mods[$mod]['proname']=$proper_name;
				}
				$this->mods[$mod]['abtxt']='';
				$this->mods[$mod]['author']='';
				if (file_exists($cp.'about.html')) {
					$htm=str_replace("\n",' ',strip_tags(file_get_contents($cp.'about.html'),PHPWS_ALLOWED_TAGS));
					preg_match_all('/<p(.*?)>(.*?)<\/p>/si', $htm, $rs);
					foreach ($rs[2] as $p) {
						if (trim($p) > '') {
							$this->mods[$mod]['abtxt'].=$this->reCode(html_entity_decode($p)).'<br />';
						}
					}
					preg_match_all('/<h[1-4]>By(.*?)<\/h/', $htm, $rs);
					$this->mods[$mod]['author']=(empty($rs[1])?'':'by '.$rs[1][0]);
				} else {
					$this->mods[$mod]['abtxt']='';
				}
				$this->mods[$mod]['docs']=array();
				if (is_dir($dp)) {
					$doc=opendir($dp);
					// catch all existing docs 
					while (FALSE !== ($file = readdir ($doc))) {
						if (substr($file,0,1) != '.' and $file != '..') {
							$this->mods[$mod]['docs'][]=$file;
							$x=md5(SITE_HASH.$mod.$file);
							$this->mods[$mod]['xref'][]=$x;
							$mod==''
							? $_SESSION[NGREADME]['docs'][$x]='docs/'.$file
							: $_SESSION[NGREADME]['docs'][$x]='mod/'.$mod.'/docs/'.$file;
						}
					}
					closedir($doc);
					natcasesort($this->mods[$mod]['docs']);
				}
			}
			ksort($this->mods);
			$_SESSION[NGREADME]['mods']=$this->mods;
		}
	}
	
	protected function _modDocList($mod) 
	{
		// tells all docs of a mod in itemkey notation
		if ($this->context==NGREADME) {
			$item=array();
			foreach ($this->mods[$mod]['docs'] as $doc) {
				if ($mod=='') {
					$ref='/'.'docs/'.$doc;
				} else {
					$ref='/mod/'.$mod.'/docs/'.$doc;
				}
				$item[]=strtr($ref,'/',':');
			}
			return $item;
		}
	}
	

	// key 'n search
	
	protected function _kysGetKey($mod,$doc,$getkeyobj=true) 
	{
		if ($this->context==NGREADME) {
			if ($mod=='') {
				$this->kyref='/docs/'.$doc;
			} else {
				$this->kyref='/mod/'.$mod.'/docs/'.$doc;
			}
			$this->kyitem=strtr($this->kyref,'/',':');
			$this->kyid=abs(crc32($this->kyitem));
			if ($getkeyobj) {
				$corekey = new key;
				$this->kyobj=$corekey->getKey(NGREADME,$this->kyid,$this->kyitemname);
			}
		}
	}
	
	protected function _kysCountIx() 
	{
		if ($this->context==NGREADME) {
			if ($this->kyobj) {
				$search = new Search($this->kyobj);
				if (is_array($search->keywords)) {
					sort($search->keywords);
					$this->kywords='['.implode('] [',$search->keywords).']';																																										
					$this->kywcount=count($search->keywords);	
				}
			} else {
				$this->kywords='';
			}
		}
	}
	
	protected function _kysNewKey($ngitem, $mod) 
	{
		//	$ngitem is like :mod:modulename:docs:docname
		//	$ngitemid is abs crc32 of ngitem
		//	$ngitemname is always ReadmeFiles
		if ($this->context==NGREADME && Current_user::isDeity()) {
			$ngitemid=abs(crc32($ngitem));
			$ky=Key::getKey(NGREADME,$ngitemid,$this->kyitemname);
			if ($ky) {
				$key = new Key($ky->id);
				$key->delete();
			}
			if (isset($_SESSION[NGREADME]['mods'][$mod]['abtxt'])) {
				$key = new Key;
				$key->setModule(NGREADME);
				$key->setItemName($this->kyitemname);
				$key->setItemId($ngitemid);
				$key->setTitle($ngitem);
				$key->setSummary($_SESSION[NGREADME]['mods'][$mod]['abtxt']);
				$key->setUrl('ngreadme/op/see/r/'.$ngitemid);
				$key->save();
				$corekey = new key;
				$this->kyobj=$corekey->getKey(NGREADME,$ngitemid,$this->kyitemname);
			}
		}
	}
	
	protected function _kysDelKey($ngitem, $mod) 
	{
		if ($this->context==NGREADME && Current_user::isDeity()) {
			$ngitemid=abs(crc32($ngitem));
			$ky=Key::getKey(NGREADME,$ngitemid,$this->kyitemname);
			if ($ky) {
				$key = new Key($ky->id);
				$key->delete();
				$key->save();
			}
		}
	}

	protected function _kysBuildIx($ngitem, $mod) 
	{
		// $ngitem is like :mod:modulename:docs:docname
		if ($this->context==NGREADME && Current_user::isDeity()) {
				$this->_kysNewKey($ngitem, $mod);
				$docname=PHPWS_SOURCE_DIR.substr(strtr($ngitem,':','/'),1);
				if (file_exists($docname)) {
					$excpt=array('#', '-', ';', ' & ');
					$docdata=str_replace($excpt,' ',$this->reCode(strip_tags(file_get_contents($docname),PHPWS_ALLOWED_TAGS)));
					if ($docdata) {
						if (isset($_SESSION[NGREADME]['mods'][$mod]['abtxt'])) {
							$search = new Search($this->kyobj);
							$search->loadKeywords();
							$search->resetKeywords();
							$search->addKeywords($docdata);
						//	$search->addKeywords($_SESSION[NGREADME]['mods'][$mod]['abtxt']);
							$search->save();
						}
					}
				}
		}
	}
	
	protected function kysBix($ngitem, $mod) 
	{
		if ($this->context==NGREADME && Current_user::isDeity()) {
			$this->_kysBuildIx($ngitem,$mod);
		}
	}
	
	protected function kysDix($ngitem, $mod) 
	{
		if ($this->context==NGREADME && Current_user::isDeity()) {
			$this->_kysDelKey($ngitem, $mod);
		}
	}
	
	protected function kysShow($itemid) 
	{
		isset($_SESSION['search']['search_phrase'])?$look=$_SESSION['search']['search_phrase']:$look='';
		$key=Key::getKey(NGREADME,$itemid,$this->kyitemname);
		$doc=PHPWS_SOURCE_DIR.substr(str_replace(':','/',$key->title),1);
		if (file_exists($doc)) {
			$data=$this->reCode(strip_tags(file_get_contents($doc),PHPWS_ALLOWED_TAGS));
			if ($data) {
				$fwords=explode(' ',$look);
				$cwords=array();
				foreach ($fwords as $word) {
					$cwords[]='<span class="hilite">'.$word.'</span>';
				}
				$this->feedContent(gettext('Found').'&nbsp;&nbsp;<span id="searchtimes">&nbsp;</span>&nbsp;&nbsp;<i>"'
				.	'<span id="searchphrase">'.$look.'</span>'
				.	'"</i>&nbsp;&nbsp;in&nbsp;'
				.	str_replace(':','/',$key->title)
				.	'&nbsp;&nbsp;<a class="nmea" onclick='."'".'nmePosit()'."'".'>'.gettext('NextPosition').'</a>'
				.	'&nbsp;&nbsp;<a class="nmea" href='."'".'javascript:history.back()'."'".'>'.gettext('BackToSearchresults').'</a>'
				.	'<pre id="searchSelect" class="nmeshown">'
				.	str_ireplace($fwords,$cwords,$data)
				.	'</pre>');
			} else {
				$this->feedContent(gettext('Sorry, no data available.'));
			}
		} else {
			$this->feedContent(gettext('Sorry, file does not exists').' ('.gettext('yet more').'.)');
		}
	}
	
	// ngHelp
	
	public function ngHelp($id,$txt) 
	{
		$ht='<a class="nmetext" onClick="nmeClick('."'".$id."'"
		.	')" onMouseOver="nmeOvr('."'".$id."'".')" onMouseOut="nmeOff('."'".$id."'".')">'
		.	'<img src="mod/ngreadme/img/info.png" class="nmeimg" alt="i" /></a>'
		.	'<span id="'.$id.'" class="nmetext">'.$txt.'</span>';
		return $ht;
	}
	
	protected function _alink($text,$lnkar) 
	{
		return self::SPS.PHPWS_Text::rewriteLink($text, NGREADME, $lnkar);
	}
	
	protected function _alink0($text,$lnkar) 
	{
		return PHPWS_Text::rewriteLink($text, NGREADME, $lnkar);
	}
	protected function reCode($txt) {
		return str_replace('<','<span>&lt;</span>',$txt);
	}
}

?>
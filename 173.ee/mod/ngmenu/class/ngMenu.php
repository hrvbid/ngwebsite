<?php
/**
    * ngMenu module for phpWebSite / ngWebSite
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
	define ('NGMENU', 'ngmenu');
	define ('NGMENUMID', 'nmu');
	
	// may be shared
	if (!defined('NGSAYOK')) {
		define('NGSAYOK', '<img id="ngok" src="'.PHPWS_SOURCE_HTTP.'mod/ngmenu/img/ok.10.gif" alt=" ok " />');
	}
	if (!defined('NGSP3')) {
		define ('NGSP3', '&nbsp;&nbsp;&nbsp;');
	}
	if (!defined('NGBR')) {
		define ('NGBR', '<br />');
	}
	if (!defined(NGBU)) {
		define('NGBU','ngBackup');
	}

class ngMenu20 {

	var $context = '';
	var $conuser = '';
	var $mname='';
	var $mtitle='';
	var $mlang='';
	var $mpinpoint='';
	var $mpinpage='';
	var $mvertical='';
	var $mpinall='';
	var $mpublic='';
	var $mowner=0;
	var $msrc='';
	var $mdst='';
	var $msg='';
	var $rsMenu=array();
	var $rsMenus=array();

    public function __construct()
	{
		$this->context=PHPWS_Core::getCurrentModule();
		$this->conuser=Current_user::isLogged();
		$this->authkey=Current_User::getAuthKey();
	}
	
	public function index()
	{
		$op = $this->vrqop();
		switch ($op) {
			case 'edit':
				$this->wop();
				break;
			case 'list':
				$this->listMenu();
				break;
			case 'view':
				$this->viewMenu();
				break;
			case 'makeCancel':
				$this->mname=$this->mtitle=
					$this->msrc=$this->mdst=
					$this->mvertical=$this->mpinall=$this->mpublic='';
				$this->wop();
				break;
			case 'makeOpen':
				$this->openMenu();
				$this->wop();
				break;
			case 'makeSave':
				$this->makeMenu();
				$this->wop();
				break;
			case 'delY':
				$this->delMenu();
				break;
			case 'bu':
				$this->buData();
				$this->listMenu();
				break;
			default:
				$this->listMenu();
				break;
		}
	}
	
	public function feedBox($text,$box=false,$htmlid='')
	{
		if ($this->context==NGMENU) {
			javascript('jquery');
			javascript('ng_com');
			Layout::addStyle(NGMENU,'style.css');
			if ($this->mvertical) {
				Layout::addStyle(NGMENU,'superfish-vertical.css');
			}
			if ($htmlid=='') {
				$cnt='<div>'.$text.'</div>';
			} else {
				$cnt='<div id="'.$htmlid.'" class="ngmenucnt">'.$text.'</div>';
			}
			//$boxcnt=PHPWS_Template::process($tpl, NGMENU, 'block.tpl');
			if ($box) {
				Layout::add($cnt,'','smallbox');
			} else {
				Layout::add($cnt);
			}
		}
	}

	protected function sideBox($title,$text) 
	{
		if ($this->context==NGMENU) {
			Layout::addStyle(NGMENU,'style.css');
			$tpl['TITLE'] = $title;
			$tpl['CONTENT']=$text;
			$boxcnt=PHPWS_Template::process($tpl, NGMENU, 'toc.tpl');
			Layout::add($boxcnt,'','smallbox');
		}
	}
	
	protected function tocBox() {
		if ($this->context==NGMENU) {
			$cnt='';
			$rs=$this->dSelect(true,array('msite','mname','mlang','mtitle'));
			foreach ($rs as $row) {
				$cnt.=$row['mname'].' '.$row['mlang'].' (<i>'.$row['mtitle'].'</i>)<br />';
			}
			$this->sideBox('toc@ngMenu',$cnt);
		}
	}
	
	protected function wop() 
	{
		if ($this->context==NGMENU) {
			if ($this->conuser) {
				if (Current_User::allow(NGMENU, 'edit')) {
					$form = new PHPWS_Form();
					$form->setAction('ngmenu/op/make');
		
					$form->add('mname', 'text');
					$form->setValue('mname', $this->mname);
					$form->setTitle('mname', gettext('The required name of the menu [a-z0-9]'));
					$form->setSize('mname', 15);
					$form->setMaxSize('mname', 32);
			
					$form->add('mtitle', 'text');
					$form->setValue('mtitle', $this->mtitle);
					$form->setTitle('mtitle', gettext('The required title of the menu [a-zA-Z0-9_ ]'));
					$form->setSize('mtitle', 15);
					$form->setMaxSize('mtitle', 64);
				
					$form->add('mpinpoint', 'text');
					$form->setValue('mpinpoint', $this->mpinpoint);
					$form->setTitle('mpinpoint', gettext('A required peg (id or css class) [#|.]+[a-z0-9-]'));
					$form->setSize('mpinpoint', 15);
					$form->setMaxSize('mpinpoint', 32);
			
					$form->add('mpinpage', 'text');
					$form->setValue('mpinpage', $this->mpinpage);
					$form->setTitle('mpinpage', gettext('The content page (relative url) where the menu is to display'));
					$form->setSize('mpinpage', 15);
					$form->setMaxSize('mpinpage', 64);
				
					$form->addCheck('mvertical', true);
					if ($this->mvertical) {
						$form->setExtra('mvertical', 'checked="checked"');
					}
				
					$form->addCheck('mpinall', true);
					if ($this->mpinall) {
						$form->setExtra('mpinall', 'checked="checked"');
					}
				
					$form->addCheck('mpublic', true);
					if ($this->mpublic) {
						$form->setExtra('mpublic', 'checked="checked"');
					}
				
					$form->add('mlang', 'text');
					$form->setValue('mlang', $this->mlang);
					$form->setTitle('mlang', gettext('The optional language code (lc) of the menu [lc or lc_LC]'));
					$form->setSize('mlang', 6);
					$form->setMaxSize('mlang', 5);
					
					// textarea in deskform tpl
				
					$form->addSubmit('open', 'Open');
					$form->setExtra('open', 'class="nmubut nclbut"');
					$form->addSubmit('make', 'Save');
					$form->setExtra('make', 'class="nmubut nclbut"');
					$form->addSubmit('cancel', 'Cancel');
					$form->setExtra('cancel', 'class="nmubut nclbut"');
				
					$tpl = $form->getTemplate();
					$tpl['TITLE']='\<u> Workplace</u>@<u>ngMenu</u>';
					$tpl['LIST']=dgettext(NGMENU,'ListMenus');
					$tpl['MNAME_LABEL']='MenuName';
					$tpl['MTITLE_LABEL']='MenuTitle';
					$tpl['MPINPOINT_LABEL']='PinPoint';
					$tpl['MPINPAGE_LABEL']='PinPage';
					$tpl['MVERTICAL_LABEL']='vertical';
					$tpl['MPINALL_LABEL']='pinAll';
					$tpl['MPUBLIC_LABEL']='public';
					$tpl['MLANG_LABEL']='LC';
					$tpl['VIEW_LABEL']=dgettext(NGMENU,'viewMenu');
					$tpl['VIEW']=$this->mname.'/mlang/'.$this->mlang;
					$tpl['MSG']=$this->msg;
					$tpl['EDITOR'] = $this->msrc;
					
					$cnt=PHPWS_Template::process($tpl, NGMENU, 'deskform.tpl');
					$this->feedBox($cnt);
					$this->tocBox();
				}
			} else {
				Current_User::requireLogin();
			}
		} else {
			$this->msg = dgettext(NGMENU, 'not permitted');
		}
	}
		
	protected function openMenu()
	{
		if ($this->context==NGMENU) {
			if ($this->conuser) {
				if (Current_User::allow(NGMENU, 'make')) {
					if ($this->vrqMname()) {
						$this->vrqMlang();
						$rs=$this->dSelect();
						if (!empty($rs)) {
							$this->rsMenu=$rs[0];
							$this->mtitle = $this->rsMenu['mtitle'];
							$this->mlang = $this->rsMenu['mlang'];
							$this->mpinpoint = $this->rsMenu['mpinpoint'];
							$this->mpinpage = $this->rsMenu['mpinpage'];
							$this->mvertical = $this->rsMenu['mvertical'];
							$this->mpinall = $this->rsMenu['mpinall'];
							$this->mpublic = $this->rsMenu['mpublic'];
							$this->mowner = $this->rsMenu['mowner'];
							$this->msrc = urldecode($this->rsMenu['msrc']);
							$this->mdst = html_entity_decode(urldecode($this->rsMenu['mdst']));
						} else {
							$this->msg=gettext('Menu not found');
						}
					} else {
						$this->msg=gettext('Invalid or empty MenuName');
					}
				}
			}
		}
	}
	
	protected function makeMenu()
	{
		if ($this->context==NGMENU) {
			if ($this->conuser) {
				if (Current_User::allow(NGMENU, 'make')) {
					$cnt='';
					$menuar=array();
					if ($_REQUEST['ngmenutxta']=='') {
						$this->msg.=gettext('No data, type lines with "level" [tab] "itemtitle" [tab] "ref" [enter]');
					} else {
						$lines=explode("\n",$_REQUEST['ngmenutxta']);
						foreach ($lines as $lnum => $line) {
							$ar=array_values(array_filter(explode("\t",$line)));
							if (count($ar)==3) {
								list($lvl,$item,$ref)=$ar;
								$ar=explode('.',$lvl);
								if (count($ar)<5) {
									foreach ($ar as $n) {
										if (preg_match('/^[0-9]*$/',$n)===1 && !empty($n)) {
										} else {
											$this->msg.=gettext('Invalid line').' (#'. ($lnum + 1)
											.	'), ' . gettext('1st field "level" empty or isNan').' "'.$lvl.'"<br />';
											break;
										}
									}
									$menuar[(string)$lvl]=array('item'=>$item,'ref'=>$ref,'x'=>count($ar));
								} else {
									$this->msg.=gettext('Invalid line').' (#'. ($lnum + 1)
									.	'), '.gettext('1st field "level" max 4, has').' '.count($ar).'<br />';
								}
							} else {
								$this->msg.=gettext('Invalid line').' (#'. ($lnum + 1)
								.	'), '.gettext('instead of 3 fields, found').' '.count($ar).'<br />';
							}
						}
						$this->msg.=$this->getRqFields();
						if ($this->msg=='') {
							ksort($menuar);
							$x="0";
							$c=(isset($_REQUEST['mvertical']) && $_REQUEST['mvertical']==='1')
								?' class="sf-menu sf-vertical"':' class="sf-menu"';
							foreach ($menuar as $k => $v) {
								$href=htmlentities(($v['ref']=='.')?'#':rtrim($v['ref']));
								if ($v['ref']=='.') {
									// note: does not prevent sfish to build a link (a href .)
									$lia=htmlentities($v['item']);
								} else {
									// $href=rtrim($v['ref']);
									$ext=(strpos($href,'http://')===0)?'target="_blank"':'';
									$lia='<a '.$ext.' href="'.$href.'">'.htmlentities($v['item']).'</a>';
								}
								if ($v['x']==$x) {
									$cnt.='</li><li>'.$lia;
								} elseif ($v['x']>$x) {
									$cnt.='<ul'.$c.'><li>'.$lia;
									$c='';
									$x=$v['x'];
								} else {
									$cnt.='</li>';
									for ($i=$x; $i>$v['x']; $i--) {
										$cnt.='</ul ></li >';
									}
									$cnt.='<li>'.$lia;
									$x=$v['x'];
								}
							}
							$cnt.='</li>';
							for ($i=$x; $i>1; $i--) {
								$cnt.='</ul ></li >';
							}
							$cnt.='</ul>';
							// $cnt.='<br /><pre>'.print_r($menuar,true).'</pre>';
							$this->mdst=$cnt;
							$this->saveMenu();
						}	
					}
				}
			}
		}
	}
	
	protected function saveMenu()
	{
		if ($this->context==NGMENU) {
			if ($this->conuser) {
				if (Current_User::allow(NGMENU, 'make')) {
					$this->rsMenu['mname'] = $this->mname;
					$this->rsMenu['mtitle'] = $this->mtitle;
					$this->rsMenu['mlang'] = $this->mlang;
					$this->rsMenu['mpinpoint'] = $this->mpinpoint;
					$this->rsMenu['mpinpage'] = $this->mpinpage;
					$this->rsMenu['mvertical'] = $this->rsMenu['mvertical'] = $this->mvertical;
					$this->rsMenu['mpinall'] = $this->rsMenu['mpinall'] = $this->mpinall;
					$this->rsMenu['mpublic'] = $this->rsMenu['mpublic'] = $this->mpublic;
					$this->rsMenu['mowner'] = $this->rsMenu['mowner'] = Current_user::getId();
					$this->rsMenu['msrc'] = $this->rsMenu['msrc'] = urlencode($this->msrc);
					$this->rsMenu['mdst'] = urlencode(''.$this->mdst);
					if ($this->msg=='') {
						$rs=$this->dSelect(false, array('mname','mlang'));
						if(empty($rs)) {
							$cc=$this->dInsert();
							$this->msg.='"'.trim($this->mname.' '.$this->mlang).'" '.dgettext(NGMENU,'inserted').' '.$cc;
						} else {
							$cc=$this->dUpdate();
							$this->msg.='"'.trim($this->mname.' '.$this->mlang).'" '.dgettext(NGMENU,'updated').' '.$cc;
						}
						// enforce rt refresh
						$_SESSION['ngmenu']['reset']=true;
					}
				}
			}
		}
	}

	protected function listMenu()
	{
		if ($this->context==NGMENU) {
			if ($this->conuser) {
				if (Current_User::allow(NGMENU, 'list')) {
					$cnt='<div id="nmuwop" class="ngwop"><h2 class="nmuwophx">\<u> Workplace</u>@<u>ngMenu</u></h2>';
					$cnt.=NGSP3.NGSP3.'<a href="ngmenu/op/edit">Editor</a>';
					$cnt.=NGSP3.NGSP3.'<a href="ngmenu/op/bu">'.dgettext(NGMENU,'BackupMyData').'</a>'.NGBR;
					$cnt.='<div id="ngmenumsg">'.$this->msg.'</div>';
					$rs=$this->dSelect(true);
					if (!empty($rs)) {
						$cnt.=	'<table class="'.NGMENUMID.'ngtable ngtable">'
						.		'<thead class="'.NGMENUMID.'ngthead">'
						.		'<tr><th class="txtright"></th><th>Menu</th><th>LC</th><th>Titel</th><th>P</th><th>Op</th><th>Where</th></tr></thead>'
						.		'<tbody class="'.NGMENUMID.'ngtbody">';
						$zebra='';
						foreach ($rs as $n => $row) {
							$zebra=='0'?$zebra='1':$zebra='0';
							$uqn = md5(uniqid());
							$_SESSION[NGMENU][$this->authkey][$uqn]=array('mname'=>$row['mname'], 'mlang'=>$row['mlang']);
							$cnt.='<tr class="bgcolor'.$zebra.'">'
							.	'<td class="txtright"><input type="checkbox" value="Y" title="NMU075A '
							.	gettext('check to pre-confirm this menu delete').'" name="nmuyn" id="nmuc'.$uqn.'" /></td>'
							.	'<td>'.$row['mname'].'</td><td>'.$row['mlang'].'</td>'
							.	'<td>'.$row['mtitle'].'</td>'
							.	'<td>'.($row['mpublic']?'Y':'N').'</td>'
							.	'<td><a href="ngmenu/op/makeOpen/mname/'.$row['mname'].'/mlang/'.$row['mlang'].'">editMenu</a>'
							.	NGSP3.'<a href="ngmenu/op/view/mname/'.$row['mname'].'/mlang/'.$row['mlang'].'">viewMenu</a>'
							.	NGSP3.'<a id="nmua'.$uqn.'" onclick="tao.run.ngmenu.nmuDelY(\''.$uqn.'\')" href="ngmenu/op/delY/">deleteMenu</a></td>'
							.	'<td class="mono">'.$row['mpinpoint'].'@'.($row['mpinall']?'*':$row['mpinpage']).'</td>'
							.	'</tr>';
						}
						$cnt.='</tbody></table>';
					} else {
						$cnt.='<p>'.dgettext(NGMENU,'No menus available')
						.	', <a href="ngmenu/op/edit">'.dgettext(NGMENU,'edit a new menu').'</a></p>';
					}
					$cnt.='</div>';
					$this->feedBox($cnt);
					$this->tocBox();
				}
			} else {
				Current_User::requireLogin();
			}
		}
	}
	
	public function delMenu()
	{
		if ($this->context==NGMENU) {
			if ($this->conuser) {
				if (Current_User::allow(NGMENU, 'dely')) {
					if (isset($_REQUEST[$this->authkey])
					&& !empty($_REQUEST[$this->authkey])
					&& preg_match('/^[0-9a-z]*$/',$_REQUEST[$this->authkey])===1) {
						$uqn = $_REQUEST[$this->authkey];
						if (is_array($_SESSION[NGMENU][$this->authkey][$uqn])) {
							$this->mname=$_SESSION[NGMENU][$this->authkey][$uqn]['mname'];
							$this->mlang=$_SESSION[NGMENU][$this->authkey][$uqn]['mlang'];
							$cc=$this->dDelete();
							$this->msg='NMU076I "'.$this->mname.'/'.$this->mlang.'" '.gettext('deleted, row(s)').' '.$cc;
							// enforce rt refresh,
							$_SESSION['ngmenu']['reset']=true;
							unset($_SESSION[NGMENU][$this->authkey]);
							$this->listMenu();
							return;
						}
					}
					$this->msg='NMU077E '.gettext('menu not deleted because not confirmed');
					$this->listMenu();
				}
			}
		}
	}
	
	public function viewMenu()
	{
		if ($this->context==NGMENU) {
			$this->openMenu();
			$this->feedBox($this->mdst,false,'ngmenucnt'.$this->mname);
		}
	}
	
	public function getMenu()
	{
		// RT
		if ($this->context==NGMENU) {
			$this->rsMenus = $this->dSelect(true);
		}
	}
	
	protected function dInsert() {
		if ($this->context==NGMENU) {
			$db = new PHPWS_DB('ngmenu');
			$db->addValue($this->rsMenu);
			$rc=$db->insert(false);
			if ($rc===true) {
				return NGSAYOK;
			} else {
				return $rc->message;
			}
		}
	}
	
	protected function dUpdate() {
		if ($this->context==NGMENU) {
			$db = new PHPWS_DB('ngmenu');
			$db->addValue($this->rsMenu);
				$where = 'mname="'.$this->mname.'" and mlang="'.$this->mlang.'"' ;
			$db->setQWhere($where);
			$rc=$db->update();
			if ($rc===true) {
				// num of updated rows
				return NGSAYOK;
			} else {
				return $rc->message;
			}
		}
	}

	protected function dDelete() {
		if ($this->context==NGMENU) {
			$db = new PHPWS_DB('ngmenu');
			$where = 'mname="'.$this->mname.'" and mlang="'.$this->mlang.'"' ;
			$db->setQWhere($where);
			$db->setLimit("1");
			$rc=$db->delete();
			if ($rc===true) {
				return $rc;
			} else {
				return $rc->message;
			}
		}
	}

	protected function dSelect($all=false, $fl=array()) {
		// fl is the requested column field list (defaults all columns)
		if ($this->context==NGMENU) {
			$db = new PHPWS_DB('ngmenu');
			foreach ($fl as $f) {
				$db->addColumn($f);
			}
			if (!$all) {
				$where = 'mname="'.$this->mname.'" and mlang="'.$this->mlang.'"' ;
				$db->setQWhere($where);
			} else {
				$order=array('mname asc','mlang desc');
				$db->addOrder($order);
			}
			$rs = $db->select('all');
			return $rs;
		}
	}	
	
	protected function getRqFields()
	{
		if ($this->context==NGMENU) {
			$msg='';
			$msg.=$this->vrqMname()?'':' "'.htmlentities($_REQUEST['mname']).'" '.gettext('MenuName invalid').'! ';
			$msg.=$this->vrqMtitle()?'':' "'.htmlentities($_REQUEST['mtitle']).'" '.gettext('MenuTitle invalid').'! ';
			$msg.=$this->vrqMpinpoint()?'':' "'.htmlentities($_REQUEST['mpinpoint']).'" '.gettext('PinPoint invalid').'! ';
			$msg.=$this->vrqMpinpage()?'':' "'.htmlentities($_REQUEST['mpinpage']).'" '.gettext('PinPage invalid').'! ';
			$this->vrqflags('mvertical');
			$this->vrqflags('mpinall');
			$this->vrqflags('mpublic');
			$msg.=$this->vrqMlang()?'':' "'.htmlentities($_REQUEST['mlang']).'" '.gettext('LC invalid').'! ';
			if (isset($_REQUEST['ngmenutxta'])) {
				$this->msrc=htmlentities($_REQUEST['ngmenutxta'],ENT_QUOTES,'UTF-8',false);
			}
			return $msg;
		}
	}
	
	protected function vrqMname()
	{
		if ($this->context==NGMENU) {
			if (isset($_REQUEST['mname'])
			&& !empty($_REQUEST['mname'])
			&& preg_match('/^[0-9a-z]*$/',$_REQUEST['mname'])===1)
			{
				(string)$this->mname=$_REQUEST['mname'];
				return true;
			}
		}
		return false;
	}
	
	protected function vrqMtitle()
	{
		if ($this->context==NGMENU) {
			if (isset($_REQUEST['mtitle'])
			&& preg_match('/^[0-9a-zA-Z_\s]*$/',$_REQUEST['mtitle'])===1)
			{
				(string)$this->mtitle=$_REQUEST['mtitle'];
				return true;
			}
		}
		return false;
	}
	
	protected function vrqMlang()
	{
		if ($this->context==NGMENU) {
			if (isset($_REQUEST['mlang'])
			&& preg_match('/^([a-z][a-z])?([_][A-Z][A-Z])?$/',$_REQUEST['mlang'])===1)
			{
				(string)$this->mlang=$_REQUEST['mlang'];
				return true;
			}
		}
		return false;
	}
	
	protected function vrqMpinpage()
	{
		if ($this->context==NGMENU) {
			if (isset($_REQUEST['mpinpage'])
			&& preg_match('/^[0-9a-zA-Z_\.\-\/\#\&]*$/',$_REQUEST['mpinpage'])===1) 
			{
				if ($_REQUEST['mpinpage']=='.') {
					// is placeholder in src only
					$this->mpinpage='';
				} else {
					(string)$this->mpinpage=$_REQUEST['mpinpage'];
				}
				return true;
			}
		}
		return false;
	}
	
	protected function vrqMpinpoint()
	{
		if ($this->context==NGMENU) {
			if (isset($_REQUEST['mpinpoint'])) {
				if (preg_match('/^([\#\.])([0-9a-z\-])*$/',$_REQUEST['mpinpoint'])===1) {
					(string)$this->mpinpoint=$_REQUEST['mpinpoint'];
				} else {
					return false;
				}
			}
			return true;
		}
		return false;
	}

	protected function vrqflags($fld)
	{
		if ($this->context==NGMENU) {
			if (isset($_REQUEST[$fld])
			&& $_REQUEST[$fld]==='1') 
			{
				switch ($fld) {
				case 'mvertical':
					(string)$this->mvertical=$_REQUEST[$fld];
					return true;
					break;
				case 'mpinall':
					(string)$this->mpinall=$_REQUEST[$fld];
					return true;
					break;
				case 'mpublic':
					(string)$this->mpublic=$_REQUEST[$fld];
					return true;
					break;
				}
			}
		}
		return false;
	}
	protected function vrqop()
	{
		if ($this->context==NGMENU) {
			$op=@$_REQUEST['op'].@$_REQUEST['open'].@$_REQUEST['make'].@$_REQUEST['cancel'];
			if (preg_match('/^edit|list|view|delY|bu|makeOpen|makeSave|makeCancel$/',$op)===1) {
				return $op;
			} else {
				return '';
			}
		}
	}
	
	protected function buData() 
	{
		if ($this->context==NGMENU) {
			if ($this->conuser) {
				if (Current_User::allow(NGMENU, 'bumy')) {
					$ngbu = new ngBackup;
					$ngbu->mod=NGMENU;
					$this->msg=$ngbu->exportTable('ngmenu');
				}
			}
		}
	}
	
}

?>
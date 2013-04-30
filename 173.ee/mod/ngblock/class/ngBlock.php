<?php
/**
    * ngBlock module for phpWebSite / ngWebSite
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
	define ('NGBLOCK', 'ngblock');
	define ('NGBLOCKMID', 'nbk');
	
	// may be shared
	if (!defined('NGSAYOK')) {
		define('NGSAYOK', '<img id="ngok" src="'.PHPWS_SOURCE_HTTP.'mod/ngblock/img/ok.10.gif" alt=" ok " />');
	}
	if (!defined('NGSP3')) {
		define ('NGSP3', '&nbsp;&nbsp;&nbsp;');
	}
	if (!defined('NGBR')) {
		define ('NGBR', '<br />');
	}
	if (!defined('NGBU')) {
		define ('NGBU', 'ngBackup');
	}

class ngBlock20 {

	const PATXAOP = '/[a-zA-Z]*[a-zA-Z]/';
	
	var $context = '';
	var $conuser = '';
	var $authkey = '';
	var $bname='';
	var $btitle='';
	var $blang='';
	var $blangis='';
	var $bpinpoint='';
	var $bpinpage='';
	var $bpinall='';
	var $bpublic='';
	var $bsrc='';
	var $bdst='';
	var $msg='';
	var $rsBlock=array();
	var $rsBlocks=array();
	var $ngcom='';
	var $vtoclvl=0;
	var $gokey='';

    public function __construct()
	{
		$this->context=PHPWS_Core::getCurrentModule();
		$this->conuser=Current_user::isLogged();
		$this->authkey=Current_User::getAuthKey();
		$this->ngcom=new ngACo;
		$this->gokey=PHPWS_Settings::get('ngblock', 'gotransapikey');
	}
	
	public function index()
	{
		$op = $this->vrq('op');
		
		// FG
		switch ($op) 
		{
			case 'edit':
				$this->wop();
				break;
			case 'list':
				$this->listBlock();
				break;
			case 'ltoc':
				$this->tocBox();
				break;
			case 'view':
				$this->viewBlock();
				break;
			case 'makeCancel':
				$this->bname=$this->btitle=
					$this->bsrc=$this->bdst=
					$this->bpinall=$this->bpublic='';
				$this->wop();
				break;
			case 'makeOpen':
				$this->openBlock(true);
				$this->wop();
				break;
			case 'makeSave':
				$this->makeBlock();
				break;
			case 'delY':
				$this->delBlock();
				break;
			case 'bu':
				$this->buData();
				$this->listBlock();
				break;
			case 'akey':
				$this->apiKey();
				break;
			case 'skey':
				// VER
				$this->apiKeySet($_REQUEST['apik']);
				break;
		}
		
		// BG
		if (isset($_REQUEST['xaop'])) {
			$xaop=$this->vrq('xaop');
			switch ($xaop) 
			{
				default:
					$_SESSION['BG']=' ';
					return;
					break;
			}
		}
	}
	
	public function feedBlock()
	{
		if ($this->context==NGBLOCK) {
			if ($this->rsBlock) {
				$cnt='<div id="'.'ngblockcnt'.str_replace('.','dot',$this->rsBlock['bname'])
				.		 '" class="ngblockcnt">';
				
				if ($this->rsBlock['btitle'] > '') {
					$cnt.='<div class="'.NGBLOCKMID.'box-title box-title"><h1>'
					.			$this->rsBlock['btitle'].'</h1></div>';
				}
				
				$cnt.='<div class="'.NGBLOCKMID.'box-content box-content">'
				.				$this->tagArt(urldecode($this->rsBlock['bdst']))
				.		'</div>'
				.	'</div>';
			} else {
				$cnt=$this->msg;
			}
			Layout::add($cnt);
		}
	}

	public function feedBox($text,$box=false,$htmlid='')
	{
		if ($this->context==NGBLOCK) {
			javascript('ng_com');
			if ($htmlid=='') {
				$cnt='<div>'.$text.'</div>';
			} else {
				$cnt='<div id="'.$htmlid.'" class="'.NGBLOCKMID.'cnt">'
				.		'<div class="'.NGBLOCKMID.'box-title box-title"><h1>'.$this->btitle.'*</h1></div>'
				.		'<div class="'.NGBLOCKMID.'box-content box-content">'.$text.'</div>'
				.	'</div>';
			}
			if ($box) {
				Layout::add($cnt,'','smallbox');
			} else {
				Layout::add($cnt);
			}
		}
	}
	
	protected function sideBox($title,$text) 
	{
		if ($this->context==NGBLOCK) {
			$tpl['TITLE'] = $title;
			$tpl['CONTENT']=$text;
			$boxcnt=PHPWS_Template::process($tpl, NGBLOCK, 'toc.tpl');
			Layout::add($boxcnt,'','smallbox');
		}
	}
	function simple($display='') {
		if ($this->context==NGBLOCK) {
			$tpl['TITLE'] = NGBLOCK;
			$tpl['MSG'] = $this->msg;
			$tpl['CONTENT'] = $display;
			$content=PHPWS_Template::process($tpl, NGBLOCK, 'simple.tpl');
			Layout::add($content);
		}
	}


	protected function wop() 
	{
		if ($this->context==NGBLOCK) {
			if ($this->conuser) {
				if (Current_User::allow(NGBLOCK, 'edit')) {

					$form = new PHPWS_Form();
					$form->setAction('ngblock/op/make');
		
					$form->add('bname', 'text');
					$form->setValue('bname', $this->bname);
					$form->setTitle('bname', 'NBK011I ' . gettext('The required name of the block [a-z0-9]'));
					$form->setSize('bname', 17);
					$form->setMaxSize('bname', 32);
					$form->setExtra('bname', 'class="nbkfld nclfld"');
			
					$form->add('btitle', 'text');
					$form->setValue('btitle', $this->btitle);
					$form->setTitle('btitle', 'NBK012I ' . gettext('The required title of the block [a-zA-Z0-9_]'));
					$form->setSize('btitle', 17);
					$form->setMaxSize('btitle', 64);
					$form->setExtra('btitle', 'class="nbkfld nclfld"');
				
					$form->add('bpinpoint', 'text');
					$form->setValue('bpinpoint', $this->bpinpoint);
					$form->setTitle('bpinpoint', 'NBK013I ' . gettext('A required peg (id or class) [#|.]+[a-z0-9][-]'));
					$form->setSize('bpinpoint', 17);
					$form->setMaxSize('bpinpoint', 32);
					$form->setExtra('bpinpoint', 'class="nbkfld nclfld"');
			
					$form->add('bpinpage', 'text');
					$form->setValue('bpinpage', $this->bpinpage);
					$form->setTitle('bpinpage', 'NBK014I ' . gettext('The content page (href) where the block is to display [a-z0-9]'));
					$form->setSize('bpinpage', 17);
					$form->setMaxSize('bpinpage', 64);
					$form->setExtra('bpinpage', 'class="nbkfld nclfld"');
				
					$form->addCheck('bpinall', true);
					$form->setTitle('bpinall', 'NBK015I ' . gettext('Check if the block is to display for each content page'));
					if ($this->bpinall) {
						$form->setExtra('bpinall', 'checked="checked"');
					}
				
					$form->addCheck('bpublic', true);
					$form->setTitle('bpublic', 'NBK016I ' . gettext('Check if the block is visible for anonymous users also'));
					if ($this->bpublic) {
						$form->setExtra('bpublic', 'checked="checked"');
					}
				
					$form->add('blang', 'text');
					$form->setValue('blang', $this->blang);
					$form->setTitle('blang', 'NBK017I ' . gettext('The optional language code (lc) of the block [lc or lc_LC]'));
					$form->setSize('blang', 6);
					$form->setMaxSize('blang', 5);
					$form->setExtra('blang', 'class="nbkfld nclfld"');

					$gkey=PHPWS_Settings::get(NGBLOCK, 'gotransapikey');
					if ($gkey>'') {
						$nglocale = new ngUCo;
						$shortlcs=$nglocale->getAllLanguages(true);
						$shortlcs[''] = '..';
						ksort($shortlcs);
						$form->addSelect('lcfrom', $shortlcs);
						if (isset($_SESSION[NGBLOCK]['transfrom'])) {
							$form->setMatch('lcfrom', $_SESSION[NGBLOCK]['transfrom']);
						}
						$form->setExtra('lcfrom', 'class="nbkfld nclfld"');	// does not apply					
						$form->setExtra('lcfrom', 'onchange="tao.run.ngblock.transChange()"');
						
						$form->addSelect('lcto', $shortlcs);
						if (isset($_SESSION[NGBLOCK]['transto'])) {
							$form->setMatch('lcto', $_SESSION[NGBLOCK]['transto']);
						}
						$form->setExtra('lcto', 'class="nbkfld nclfld"');	// does not apply
						$form->setExtra('lcto', 'onchange="tao.run.ngblock.transChange()"');
					}
					
					$form->addSelect('fxb', $this->fxBe());
					$form->setClass('fxb', 'jsfxb');
					$form->setExtra('fxb', 'onchange="tao.run.ngblock.ngFxB()"');
					// fcm
					$form->addSelect('fcm', array(	'I'=>gettext('Images'),
													'M'=>gettext('Multimedia'),
													'D'=>gettext('Documents')));
					$form->setTitle('fcm', gettext('select a file cabinet file type category'));
					$form->setId('fcm', 'nclfcm-single');
					$form->setClass('fcm', 'nclfcselect nclfcselectm');
					$form->setExtra('fcm', 'onchange="tao.run.ncl.nclFcM(this)"');
					// fcf
					$fcf=array('' => '...');
					$form->addSelect('fcf', $fcf);
					$form->setId('fcf', 'nclfcf-single');
					$form->setTitle('fcf', 'NBK021I ' . gettext('select a folder from the file cabinet'));
					$form->setExtra('fcf', 'onclick="tao.run.ncl.nclFcF(this)" onchange="tao.run.ncl.nclFcFc(this)"');
					// fcp
					$fcp=array('' => '...');
					$form->addSelect('fcp', $fcp);
					$form->setId('fcp', 'nclfcp-single');
					$form->setTitle('fcp', 'NBK022I ' . gettext('select a file from the current file cabinet folder'));
					$form->setExtra('fcp', 'onchange="tao.run.ncl.nclFcP(this)"');
					
					// textarea in deskform tpl
				
					$form->addSubmit('open', 'Open');
					$form->setExtra('open', 'class="nbkbut nclbut"');
					$form->addSubmit('make', 'Save');
					$form->setExtra('make', 'class="nbkbut nclbut"');
					$form->addSubmit('cancel', 'Cancel');
					$form->setExtra('cancel', 'class="nbkbut nclbut"');
				
					$tpl = $form->getTemplate();
					$tpl['TITLE']='\<u> Workplace</u>@<u>ngBlock</u>';
					$tpl['LIST']=dgettext(NGBLOCK,'ListBlocks');
					$tpl['BNAME_LABEL']='BlockName';
					$tpl['BTITLE_LABEL']='BlockTitle';
					$tpl['BPINPOINT_LABEL']='PinPoint';
					$tpl['BPINPAGE_LABEL']='PinPage';
					$tpl['BPINALL_LABEL']='pinAll';
					$tpl['BPUBLIC_LABEL']='public';
					$tpl['BLANG_LABEL']='LC';
					$tpl['VIEW_LABEL']=dgettext(NGBLOCK,'viewBlock');
					$tpl['VIEW']=$this->bname;
					$tpl['LC']='/blang/'.$this->blang;
					$tpl['EDIT']=dgettext(NGBLOCK,'ClearEditor');
					
					$gttx='';
					if ($gkey>'') {
						$tpl['TRANSLINK']='<a onClick="tao.run.ngblock.goTrans(\''.$gkey.'\',\''.$gttx.'\')" title="'
						.gettext('Click to translate the content of the edit area by googles translation service')
						.'">translate</a>';
						$tpl['LCFROM_LABEL']=gettext('from');
						$tpl['LCTO_LABEL']='... '.gettext('to').' ...';
					} else {
						$tpl['TRANSLINK']='<a href="ngblock/op/akey" title="'
						.gettext('No translate API Key set. Click to assign the key for googles translation service')
						.'">set Api key</a>';
						$tpl['LCFROM_LABEL']=' ';
						$tpl['LCTO_LABEL']=' ';				
					}
										
					$tpl['LANG_LABEL']='LC';
					$tpl['FXB_LABEL']='FX';
					$tpl['TYPE_TITLE']='Type';
					$tpl['FOLDER_TITLE']=gettext('Folder');
					$tpl['FILES_TITLE']=gettext('File');
					$tpl['FCTXT']='<a onClick="tao.run.ncl.nclFcTnClear(this)">'.gettext('ClearFields').'</a>';
					
					$tpl['MSG']=$this->msg;
					$tpl['EDITOR'] = $this->bsrc;
					$cnt=PHPWS_Template::process($tpl, NGBLOCK, 'deskform.tpl');
					javascript('editors/cleditor');

					$this->feedBox($cnt);
					
					$this->tocBox();
				}
			} else {
				Current_User::requireLogin();
			}
		} else {
			$this->msg = 'NBK041E'.dgettext(NGBLOCK, 'not permitted');
		}
	}
		
	protected function openBlock($specific=false)
	{
		if ($this->context==NGBLOCK) {
			//	if ($this->conuser) {
				if ($this->vrqBname()) {
					
					if ($this->vrqRvtoc()) {
						if ($this->vtoclvl===0) {
							unset($_SESSION[NGBLOCK]['vtoc']);
						} else {
							$flqs=explode('.',$this->bname);
							for ($i=0; $i < $this->vtoclvl && $i < count($flqs); $i++) {
								$i===0
								? $_SESSION[NGBLOCK]['vtoc']['flqs']=$flqs[$i]
								: $_SESSION[NGBLOCK]['vtoc']['flqs'].='.'.$flqs[$i];
							}
							$_SESSION[NGBLOCK]['vtoc']['blks']=array();
							foreach ($_SESSION[NGBLOCK]['show'] as $n => $block) {
								if ( (implode('.',array_slice(explode('.',$block['bname']),0,$this->vtoclvl)) )
								=== ($_SESSION[NGBLOCK]['vtoc']['flqs'])) {
									$_SESSION[NGBLOCK]['vtoc']['blks'][$block['bname']]=$n;
								}
							}
						}
					}
					
					if (isset($_SESSION[NGBLOCK]['vtoc'])) {
						if (array_key_exists($this->bname,$_SESSION[NGBLOCK]['vtoc']['blks'])) {
							$this->vtocBox(); 
						} else {
							// discart vtoc ? (unset) when navigate to a strange schema ?
							// unset($_SESSION[NGBLOCK]['vtoc']);
						}
					}
					
					if ($this->vrqBlang()) {
						$i=false;
						if ($specific) {
							$rs=$this->dSelect('one');	
							if (count($rs)==1) {
								$i=0;
							}
						} else {
							$rs=$this->dSelect('gen');
							if ($rs) {
								if (!$this->blangis) {
									$ngcom = new ngUCo;
									$clientlc=$ngcom->getLanguage();
									foreach ($rs as $n => $v) {
										if ($v['blang']==$clientlc
										||  $v['blang']==substr($clientlc,0,2)
										||  $v['blang']=='') {
											// is exact,generic,universal
											$i=$n;
											break;
										}
									}
								} else {
									foreach ($rs as $n => $v) {
										if ($v['blang']==$this->blang) {
											$i=$n;
											break;											
										} else {
											if (substr($v['blang'],0,2)==$this->blang) {
												$i=$n;
												break;
											}
										}
									}
								}
							}
						}
						if ($i !== false) {
							$this->rsBlock=$rs[$i];
							$this->btitle = $this->rsBlock['btitle'];
							$this->blang = $this->rsBlock['blang'];
							$this->bpinpoint = $this->rsBlock['bpinpoint'];
							$this->bpinpage = $this->rsBlock['bpinpage'];
							$this->bpinall = $this->rsBlock['bpinall'];
							$this->bpublic = $this->rsBlock['bpublic'];
							$this->bsrc = urldecode($this->rsBlock['bsrc']);
							$this->bdst = urldecode($this->rsBlock['bdst']);
							$_SESSION[NGBLOCK]['lastopen']=$this->bname.'/'.$this->blang;
							return ;
						}
					}
					$this->msg='NBK042E '.gettext('Block not found');
					return ;
				}
				$this->msg='NBK043E '.gettext('Invalid or missing Block');
		// }
		}
	}
	
	protected function makeBlock()
	{
		if ($this->context==NGBLOCK) {
			if ($this->conuser) {
				if (Current_User::allow(NGBLOCK, 'make')) {
					$cnt=$msg='';
					if ($_REQUEST['single']=='') {
						$this->msg.='NBK044I '.gettext('No data to save');
					} else {
						// precode src2dst
						$this->bdst=$_REQUEST['single'];
						$this->bsrc=$_REQUEST['single'];
						$this->saveBlock();
						$this->bsrc=$_REQUEST['single'];
					}
					$this->wop();
				}
			}
		}
	}
	
	protected function saveBlock()
	{
		if ($this->context==NGBLOCK) {
			if ($this->conuser) {
				if (Current_User::allow(NGBLOCK, 'make')) {
					$this->msg.=$this->vrqBname()?'':' '.'NBK051E '.gettext('BlockName invalid').'! ';
					$this->msg.=$this->vrqBtitle()?'':' '.'NBK052E '.gettext('blockTitle invalid').'! ';
					$this->msg.=$this->vrqBpinpoint()?'':' '.'NBK053E '.gettext('PinPoint invalid').'! ';
					$this->msg.=$this->vrqBpinpage()?'':' '.'NBK054E '.gettext('PinPage invalid').'! ';
					$this->vrqflags('bpinall');
					$this->vrqflags('bpublic');
					$this->msg.=$this->vrqBlang()?'':' '.'NBK061E '.gettext('LC invalid').'! ';
					if (isset($_REQUEST['single'])) {
						$this->bsrc=$_REQUEST['single'];
					}
					$this->rsBlock['bname'] = $this->bname;
					$this->rsBlock['btitle'] = $this->btitle;
					$this->rsBlock['blang'] = $this->blang;
					$this->rsBlock['bpinpoint'] = $this->bpinpoint;
					$this->rsBlock['bpinpage'] = $this->bpinpage;
					$this->rsBlock['bpinall'] = $this->rsBlock['bpinall'] = $this->bpinall;
					$this->rsBlock['bpublic'] = $this->rsBlock['bpublic'] = $this->bpublic;
					$this->rsBlock['bsrc'] = $this->rsBlock['bsrc'] = urlencode($this->bsrc);
					$this->rsBlock['bdst'] = urlencode(''.$this->bdst);
				if ($this->msg=='') {
					$rs=$this->dSelect('one', array('bname','blang'));
					if(empty($rs)) {
						$cc=$this->dInsert();
						$_SESSION[NGBLOCK]['lastopen']=$this->bname.'/'.$this->blang;
						$this->msg.='NBK071I "'.trim($this->bname.'/'.$this->blang).'" '.dgettext(NGBLOCK,'inserted').' '.$cc;
						//	test('I-'.$cc);
					} else {
						if (isset ($_SESSION[NGBLOCK]['lastopen'])
						&& $this->bname.'/'.$this->blang === $_SESSION[NGBLOCK]['lastopen']) {
						$cc=$this->dUpdate();
						$this->msg.='NBK072I "'.trim($this->bname.'/'.$this->blang).'" '.dgettext(NGBLOCK,'updated').' '.$cc;
						//	test('U-'.$cc);
						} else {
							$this->msg.='NBK073E '.gettext('Block opened as').' "'.$_SESSION[NGBLOCK]['lastopen']
							.	'" '.gettext('not saved with different name').' "'.$this->bname.'/'.$this->blang
							.	'" '.gettext('that just exists');
						}
					}
				
					// enforce rt refresh,
					$_SESSION['ngblock']['reset']=true;
				}
				}
			}
		}
	}

	protected function listBlock()
	{
		if ($this->context==NGBLOCK) {
			if ($this->conuser) {
				if (Current_User::allow(NGBLOCK, 'list')) {
					$cnt='<div id="'.NGBLOCKMID.'wop" class="ngwop"><h2 class="nbkwophx">\<u> Workplace</u>@<u>ngblock</u></h2>';
					$cnt.=NGSP3.NGSP3.'<a href="ngblock/op/edit" class="'.NGBLOCKMID.'nga">Editor</a>';
					$cnt.=NGSP3.NGSP3.'<a href="ngcom/op/fcfl" class="'.NGBLOCKMID.'nga">FcList</a>';
					$cnt.=NGSP3.NGSP3.'<a href="ngblock/op/bu" class="'.NGBLOCKMID.'nga">BackupData</a>'.NGBR;
					$cnt.='<div id="'.NGBLOCKMID.'msg">'.$this->msg.'</div>';
					$rs=$this->dSelect('all');
					if (!empty($rs)) {
						$cnt.=	'<table class="'.NGBLOCKMID.'ngtable">'
						.		'<thead class="'.NGBLOCKMID.'ngthead">'
						.		'<tr><th class="txtright"></th><th>Block</th><th>LC</th><th>'
						.			gettext('Title').'</th><th>P</th><th>Op</th><th>'
						.			gettext('Where').'</th></tr></thead>'
						.		'<tbody class="'.NGBLOCKMID.'ngtbody">';
						$zebra='';
						foreach ($rs as $n => $row) {
							$zebra=='0'?$zebra='1':$zebra='0';
							$uqn = md5(uniqid());
							$_SESSION[NGBLOCK][$this->authkey][$uqn]=array('bname'=>$row['bname'], 'blang'=>$row['blang']);
							$cnt.='<tr class="bgcolor'.$zebra.'">'
							.	'<td class="txtright"><input type="checkbox" value="Y" title="NBK075A '
							.	gettext('check to pre-confirm this block delete').'" name="nbkyn" id="nbkc'.$uqn.'" /></td>'
							.	'<td>'.$row['bname'].'</td><td>'.$row['blang'].'</td>'
							.	'<td>'.$row['btitle'].'</td>'
							.	'<td>'.($row['bpublic']?'Y':'N').'</td>'
							.	'<td><a href="ngblock/op/makeOpen/bname/'.$row['bname'].'/blang/'.$row['blang'].'">editBlock</a>'
							.	NGSP3.'<a href="ngblock/op/view/bname/'.$row['bname'].'/blang/'.$row['blang'].'">viewBlock</a>'
							.	NGSP3.'<a id="nbka'.$uqn.'" onclick="tao.run.ngblock.nbkDelY(\''.$uqn.'\')" href="ngblock/op/delY/">deleteBlock</a></td>'
							.	'<td class="mono">'.$row['bpinpoint'].'@'.($row['bpinall']?'*':$row['bpinpage']).'</td>'
							.	'</tr>';
						}
						$cnt.='</tbody></table>';
					} else {
						$cnt.='<p>NBK081I '.dgettext(NGBLOCK,'No blocks available')
						.	', <a href="ngblock/op/edit">'.dgettext(NGBLOCK,'edit a new block').'</a></p>';
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
	
	public function delBlock()
	{
		if ($this->context==NGBLOCK) {
			if ($this->conuser) {
				if (Current_User::allow(NGBLOCK, 'dely')) {
					if (isset($_REQUEST[$this->authkey])
					&& !empty($_REQUEST[$this->authkey])
					&& preg_match('/^[0-9a-z]*$/',$_REQUEST[$this->authkey])===1) {
						$uqn = $_REQUEST[$this->authkey];
						if (is_array($_SESSION[NGBLOCK][$this->authkey][$uqn])) {
							$this->bname=$_SESSION[NGBLOCK][$this->authkey][$uqn]['bname'];
							$this->blang=$_SESSION[NGBLOCK][$this->authkey][$uqn]['blang'];
							$cc=$this->dDelete();
							$this->msg='NBK076I "'.$this->bname.'/'.$this->blang.'" '.gettext('deleted, row(s)').' '.$cc;
							// enforce rt refresh,
							$_SESSION['ngblock']['reset']=true;
							unset($_SESSION[NGBLOCK][$this->authkey]);
							$this->listBlock();
							return;
						}
					}
					$this->msg='NBK077E '.gettext('block not deleted because not confirmed');
					$this->listBlock();
				}
			}
		}
	}
	
	public function viewBlock()
	{
		if ($this->context==NGBLOCK) {
			$this->openBlock();
			if ($this->bpublic || ($this->conuser && Current_User::allow(NGBLOCK, 'make'))) {
				$jso=array();
				if (isset($_SESSION['ngblock']['jso'])) {
					$n=count($_SESSION['ngblock']['jso']);
				} else {
					$n=0;
					$_SESSION['ngblock']['jso']=array();
				}
				$_SESSION['ngblock']['jso'][$n]['bname'] = $this->bname;
				$_SESSION['ngblock']['jso'][$n]['bpinpoint'] = $this->bpinpoint;
				$_SESSION['ngblock']['jso'][$n]['blang'] = $this->blang;
				$this->ngcom->vpoolSetNode('nbk',array('mod'=>'ngblock'),$_SESSION['ngblock']['jso']);
				$this->feedBlock();
			}
		}
	}

	protected function tocBox() {
		if ($this->context==NGBLOCK) {
			$cnt='';
			$rs=$this->dSelect('all',array('bsite','bname','blang','btitle'));
			foreach ($rs as $row) {
				$cnt.='<div class="nbktocxe">';
				if ($this->conuser) {
					$cnt.='<a href="ngblock/op/makeOpen/bname/'.$row['bname'].'/blang/'.$row['blang']
					.	'" title="'.gettext('edit').'">'
					.	'<img height="10" width="10" alt="E" src="'
					.	PHPWS_SOURCE_HTTP.'mod/ngcom/img/edit.pen.png"></a> ';
				}
				$cnt.='<a href="ngblock/op/view/bname/'.$row['bname'].'/blang/'.$row['blang']
				.	'" title="'.gettext('view').' '.$row['btitle'].'">' 
				.	$row['bname'].' '.$row['blang'].'</a> (<i>'.$row['btitle'].'</i>)'
				.	'</div>';
			}
			$this->sideBox('toc@ngBlock',$cnt);
		}
	}

	protected function vtocBox() {
		if ($this->context==NGBLOCK) {
			$cnt='';
			foreach ($_SESSION[NGBLOCK]['vtoc']['blks'] as $bname => $n) {
				$cnt.='<div class="nbktocxe">';
				if ($this->conuser) {
					$cnt.='<a href="ngblock/op/makeOpen/bname/'.$bname
					.	'" title="'.gettext('edit').'">'
					.	'<img height="10" width="10" alt="E" src="'
					.	PHPWS_SOURCE_HTTP.'mod/ngcom/img/edit.pen.png"></a> ';
				}
				$cnt.='<a href="ngblock/op/view/bname/'.$bname
				.	'" title="'.gettext('view').' '.$_SESSION[NGBLOCK]['show'][$n]['btitle'].'">' 
				.	$bname.'</a> (<i>'.$_SESSION[NGBLOCK]['show'][$n]['btitle'].'</i>)'
				.	'</div>';
			}
			$this->sideBox('toc@'.$_SESSION[NGBLOCK]['vtoc']['flqs'],$cnt);
		}
	}

	
	public function getBlock()
	{
		if ($this->context==NGBLOCK) {
			$this->rsBlocks = $this->dSelect('alc');
		}
	}
	
	protected function dInsert() {
		if ($this->context==NGBLOCK) {
			$db = new PHPWS_DB('ngblock');
			$db->addValue($this->rsBlock);
			$rc=$db->insert(false);
			if ($rc===true) {
				return NGSAYOK;
			} else {
				return $rc->message;
			}
		}
	}
	
	protected function dUpdate() {
		if ($this->context==NGBLOCK) {
			$db = new PHPWS_DB('ngblock');
			$db->addValue($this->rsBlock);
				$where = 'bname="'.$this->bname.'" and blang="'.$this->blang.'"' ;
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
		if ($this->context==NGBLOCK) {
			$db = new PHPWS_DB('ngblock');
			$where = 'bname="'.$this->bname.'" and blang="'.$this->blang.'"' ;
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

	protected function dSelect($type, $fl=array()) {
		// fl is the requested column field list (defaults all columns)
		if ($this->context==NGBLOCK) {
			$db = new PHPWS_DB('ngblock');
			foreach ($fl as $f) {
				$db->addColumn($f);
			}
			switch ($type) {
				case 'one':
					$where = 'bname="'.$this->bname.'" and blang="'.$this->blang.'"' ;
					$db->setQWhere($where);
				break;
				case 'gen':
					$where = 'bname="'.$this->bname.'"';
					$db->setQWhere($where);
					$order=array('bname asc','blang desc');
					$db->addOrder($order);
				break;
				case 'all':
					$order=array('bname asc','blang asc');
					$db->addOrder($order);
				break;
				case 'alc':
					$order=array('bname asc','blang desc');
					$db->addOrder($order);
				break;
			}
			$rs = $db->select('all');
			return $rs;
		}
	}	
	
	protected function vrq($fld)
	{
		if ($this->context==NGBLOCK) {
			switch ($fld) {
			case 'bname':
				if (isset($_REQUEST['bname'])
				&& !empty($_REQUEST['bname'])
				&& preg_match('/^[0-9a-z]*$/',$_REQUEST['bname'])===1)
				{
					if (strlen($_REQUEST['bname']) <= 32)
					{
						(string)$this->bname=$_REQUEST['bname'];
						return true;
					}
				}
				break;
			case 'op':
				$op=@$_REQUEST['op'].@$_REQUEST['open'].@$_REQUEST['make'].@$_REQUEST['cancel'].@$_REQUEST['skey'];
				if (preg_match('/^edit|list|ltoc|view|delY|makeOpen|makeSave|makeCancel|fcf|fcp|bu|akey|skey$/',$op)===1) 
				{
					return $op;
				} else {
					return '';
				}
				break;
			case 'xaop':
				if (isset($_REQUEST['xaop'])) {
					$xaop=preg_replace(self::PATXAOP, '', $_REQUEST['xaop'])?'':$_REQUEST['xaop'];
					return $xaop;
				}
				return false;
				break;
			}
		}
		return false;
	}

	protected function vrqBname()
	{
		if ($this->context==NGBLOCK) {
			if (isset($_REQUEST['bname'])
			&& !empty($_REQUEST['bname'])
			&& preg_match('/^[0-9a-z\.]*$/',$_REQUEST['bname'])===1)
			{
				(string)$this->bname=$_REQUEST['bname'];
				return true;
			}
		}
		return false;
	}
	
	protected function vrqRvtoc()
	{
		if ($this->context==NGBLOCK) {
			if (isset($_REQUEST['vtoc'])
			&& !empty($_REQUEST['vtoc'])
			&& preg_match('/^[0-9]*$/',$_REQUEST['vtoc'])===1)
			{
				$this->vtoclvl=$_REQUEST['vtoc'];
				return true;
			}
		}
		return false;
	}
	
	protected function vrqBtitle()
	{
		if ($this->context==NGBLOCK) {
			if (isset($_REQUEST['btitle'])
			&& preg_match('/^[0-9a-zA-Z_\s]*$/',$_REQUEST['btitle'])===1)
			{
				(string)$this->btitle=$_REQUEST['btitle'];
				return true;
			}
		}
		return false;
	}
	
	protected function vrqBlang()
	{
		if ($this->context==NGBLOCK) {
			(bool)$this->blangis = isset($_REQUEST['blang']);
			if (!isset($_REQUEST['blang']) 
			||   empty($_REQUEST['blang'])) {
					$this->blang='';
					return true;
			}
			if (preg_match('/^([a-z][a-z])?([_][A-Z][A-Z])?$/',$_REQUEST['blang'])===1) {
				(string)$this->blang=$_REQUEST['blang'];
				return true;
			}
		}
		return false;
	}
	
	protected function vrqBpinpage()
	{
		if ($this->context==NGBLOCK) {
			if (isset($_REQUEST['bpinpage'])
			&& preg_match('/^[0-9a-zA-Z_\.\-\/\#\&\*]*$/',$_REQUEST['bpinpage'])===1) 
			{
				if ($_REQUEST['bpinpage']=='.') {
					// is placeholder in src only
					$this->bpinpage='';
				} else {
					(string)$this->bpinpage=$_REQUEST['bpinpage'];
				}
				return true;
			}
		}
		return false;
	}
	
	protected function vrqBpinpoint()
	{
		if ($this->context==NGBLOCK) {
			if (isset($_REQUEST['bpinpoint'])) {
				if (preg_match('/^([\#\.])([0-9a-z\-])*$/',$_REQUEST['bpinpoint'])===1) {
					(string)$this->bpinpoint=$_REQUEST['bpinpoint'];
				} else {
					return false;
				}
			}
			return true;
		}
	}

	protected function vrqflags($fld)
	{
		if ($this->context==NGBLOCK) {
			if (isset($_REQUEST[$fld])
			&& $_REQUEST[$fld]==='1') 
			{
				switch ($fld) {
				case 'bpinall':
					(string)$this->bpinall=$_REQUEST[$fld];
					return true;
					break;
				case 'bpublic':
					(string)$this->bpublic=$_REQUEST[$fld];
					return true;
					break;
				}
			}
		}
		return false;
	}

	protected function tagArt($html)
	{
		if ($this->context==NGBLOCK) {
			return str_replace( array('<script','</script','<html>','</html>'),
								array('&lt;<span>script</span>','&lt;<span>/script</span>','&lt;<span>html</span>&gt;','&lt;<span>/html</span>&gt;'),
					$html);
		}
	}
		
	protected function apiKey() 
	{
		if ($this->context==NGBLOCK) {
			if (Current_user::allow(NGBLOCK, 'gtsetapi')) {
				$help='<pre>'.htmlentities(@file_get_contents(PHPWS_SOURCE_DIR
					.'mod/ngblock/docs/google.translate.API-Key.txt')).'</pre>';
				$in = PHPWS_Settings::get(NGBLOCK, 'gotransapikey');
				$tpl['SUBMIT'] = gettext('Submit');
				$tpl['NGAPIK'] = $in;
				$help.=PHPWS_Template::process($tpl, NGBLOCK, 'apik.tpl');
				$this->simple($help);
			} else {
				$this->listBlock();
			}
		}
	}

	protected function apiKeySet($apik) 
	{
		if ($this->context==NGBLOCK) {
			if (Current_user::allow(NGBLOCK, 'gtsetapi')) {
				PHPWS_Settings::set(NGBLOCK, 'gotransapikey', $apik);
				PHPWS_Settings::save(NGBLOCK);
				$this->msg = gettext('Api Key set');
				$this->apiKey();
			}
		}
	}
	
	// Cnt FX Behavior
	
	protected function fxBe() 
	{
		if ($this->context==NGBLOCK) {
			$opas=array('' => '...',
						'boxscr' => 'ScrollBox',
						'coltxt' => 'ColumnText',
						'sensor' => 'AlbumShow',
						'slider' => 'SlideShow',
						'dc' 		 => 'DialogForm',
						'debug'	 =>	'Only4Debug');
			return $opas;
		}
	}


	protected function buData() 
	{
		if ($this->context==NGBLOCK) {
			if ($this->conuser) {
				if (Current_User::allow(NGBLOCK, 'bumy')) {
					$_SESSION['ngboost']['BUSIGN']['db']='ngbu.full.my.'.date("Ymd-His");
					$ngbu = new ngBackup;
					$ngbu->mod=NGBLOCK;
					$this->msg='ngblock: '.$ngbu->exportTable('ngblock');
					$ngbu->mod='filecabinet';
					$this->msg.=NGBR.'fc folders: '.$ngbu->exportTable('folders');
					$this->msg.=NGBR.'fc images: '.$ngbu->exportTable('images');
					$this->msg.=NGBR.'fc documents: '.$ngbu->exportTable('documents');
					$this->msg.=NGBR.'fc multimedia: '.$ngbu->exportTable('multimedia');
					$this->msg.=NGBR.'fc file assoc: '.$ngbu->exportTable('fc_file_assoc');
					$this->msg.=NGBR.'fc pins: '.$ngbu->exportTable('filecabinet_pins');
					unset($_SESSION['ngboost']['BUSIGN']);
				}
			}
		}
	}
	
}

?>
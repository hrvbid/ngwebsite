<?php

	// me 
	define ('NGCOM', 'ngcom');
	define ('NGCOMMID', 'ncl');
	define ('NGCOMTITLE', 'ngCom ');


class ngACo {

	const NGBR =	'<br />';
	const NGSP3 =	'&nbsp;&nbsp;&nbsp;';
	
	const PATOPS = '/[a-zA-Z]*[a-zA-Z0-9\.]/';
	
	var $context = '';
	var $conprox = '';
	var $conuser = '';
	var $userid = '';
	var $userin = '';
	var $userdn = '';
	var $userip = '';
	var $authkey = '';
	var $filename = null;
	var $filetype = null;
	var $rqfo = null;
	var $msg='';
	var $msgs=array();
	var $debug4bg = true;
	var $nfh = array();

	public function __construct()
	{
		if (defined('NGCOM')) {
			$this->context=PHPWS_Core::getCurrentModule();
			$this->conuser=Current_user::isLogged();
			if ($this->conuser) {
				$this->userid=Current_User::getId();
				$this->userin=Current_User::getUsername();
				$this->userdn=Current_User::getDisplayName();
				$this->authkey=Current_User::getAuthKey();
			}
			$this->userip=Current_User::getIP();
		}
	}
	
	public function index()
	{
		// FG
		if (isset($_REQUEST['op'])) {
			$op=preg_replace(self::PATOPS, '', $_REQUEST['op'])?'':$_REQUEST['op'];
			list($op,$opx)=explode('.',$op.'.');
			$opx=preg_replace(self::PATOPS, '', $opx)?'':$opx;
			switch ($op) 
			{
			case 'fcfl':
				$this->fcFlist();
				break;
			case 'fcpl':
				$this->rqfo=null;
				if (isset($_REQUEST['s'])
				&& preg_match('/^[0-9a-zA-Z_\s]*$/',$_REQUEST['s'])===1)
				{
					(string)$this->rqfo=$_REQUEST['s'];
				}
				$this->fcPlist();
				break;
			case 'i18n':
				PHPWS_Core::initModClass('ngcom', 'ngUCo.php');
				$i18n = new ngUco;
				$i18n->index($opx);
				break;
			case 'nra':
				PHPWS_Core::initModClass('ngcom', 'ngRac.php');
				$nra = new ngRac;	
				$nra->index($opx);
				break;
			case 'nse':
				PHPWS_Core::initModClass('ngcom', 'ngSvgEdit.php');
				$nse = new ngSvgE;	
				$nse->index($opx);
				break;
			}
		}
		
		// BG
		if (isset($_REQUEST['xaop'])) {
			$xaop=preg_replace(self::PATOPS, '', $_REQUEST['xaop'])?'':$_REQUEST['xaop'];
			switch ($xaop) 
			{
				case 'fcf':
					$_SESSION['BG']=$this->fcFo();
					return;
					break;
				case 'fcfi':
					$_SESSION['BG']=$this->fcFo('i');
					return;
					break;
				case 'fcfd':
					$_SESSION['BG']=$this->fcFo('d');
					return;
					break;
				case 'fcfm':
					$_SESSION['BG']=$this->fcFo('m');
					return;
					break;
				case 'fcp':
					$_SESSION['BG']=$this->fcPi();
					return;
					break;
				case 'fcpi':
					$_SESSION['BG']=$this->fcPi('i');
					return;
					break;
				case 'fcpd':
					$_SESSION['BG']=$this->fcPi('d');
					return;
					break;
				case 'fcpm':
					$_SESSION['BG']=$this->fcPi('m');
					return;
					break;
				case 'fcr':
					$_SESSION['BG']=$this->fcTnRe();
					return;
					break;
				case 'fcra':
					$_SESSION['BG']=$this->fcTnReAll();
					return;
					break;
				case 'fcrotw':
					$_SESSION['BG']=$this->fcImgRot('w');
					return;
					break;
				case 'fcrote':
					$_SESSION['BG']=$this->fcImgRot('e');
					return;
					break;
				case 'fcrots':
					$_SESSION['BG']=$this->fcImgRot('s');
					return;
					break;
				case 'taopi':
					$_SESSION['BG']=$this->taoUpPi();
					return;
					break;
				case 'taoanu':
					$_SESSION['BG']=$this->taoUpAnu();
					return;
					break;
				case 'imin':
					// ver picname
					$parm=$_REQUEST['in'];
					$_SESSION['BG']=$this->getImgIn($parm);
					return;
					break;
				default:
					$_SESSION['BG']=' ';
					return;
					break;
			}
		}
	}
	
	// FG Api
	
	public function vpoolSetNode($inst,$vars=array(),$jso=array()) {
		if (isset($vars)) {
			$mod=PHPWS_Core::getCurrentModule();
			$iid = preg_replace('/[a-z][a-z0-9\-]*/', '', $inst)?'':$inst;
			$node = '<var id="'.$iid.uniqid()
			.		'" class="vset hidden" data-mod="'.$mod.'" data-iid="'.$iid.'" data-use="vpool"';
			foreach ($vars as $k=>$v) {
				if ($k=='mod' || $k=='use' || $k =='iid') continue;
				// ver $k as jsvarname
				$node.= ' data-'.(preg_replace('/[a-z][a-zA-Z0-9_]*/', '', $k)?'':$k).'="'.addslashes($v).'"';
			}
			$node.='>';
			$node.=(isset($jso))?json_encode($jso):'';
			$node.='</var>';
			Layout::add($node);
		}
	}
	
	public function vshrSetNode($inst,$jso=array()) {
			$node = '<var id="'.(preg_replace('/[a-z][a-z0-9\-]*/', '', $inst)?'':$inst).uniqid()
			.		'" class="vset hidden" data-use="vshr" data-mod="'.PHPWS_Core::getCurrentModule().'">';
			$node.=(isset($jso))?json_encode($jso):'';
			$node.='</var>';
			Layout::add($node);
	}
	
	public function vi18nSetMsg($mid,$jso=array()) {
			$mod = preg_replace('/[a-z][a-z0-9\-]*/', '', $mid)?'':$mid;
			$node = '<var id="'.$mod.uniqid().'" class="vmsg hidden" data-use="vmsg" data-mod="'.$mod.'">';
			$node.=(isset($jso))?json_encode($jso):'';
			$node.='</var>';
			Layout::add($node);
	}

	// File Handler
	
	public function prepareUp() {
		// &->nfh umode upctitle upctext upltitle upltext
		if ((!empty($this->conprox) && $this->conprox == $this->context)
		||  (empty($this->conprox)	&& $this->context==NGCOM))
		{
			// prepare msgs
			$this->msgs=array(
				'nfh001e'=>'NFH001E '.gettext('your upload file count exceeded'),
				'nfh002e'=>'NFH002E '.gettext('your upload file size exceeded')
			);
			
			$cnt=gettext('invalid umode');
			if (isset($this->nfh['umode'])
			&& ($this->nfh['umode']=='apu'
			||  $this->nfh['umode']=='anu'))
			{
				if (!isset($this->nfh['upctitle'])) {
					$this->nfh['upititle']=gettext('Show my files');
				}
				if (!isset($this->nfh['upctext'])) {
					$this->nfh['upitext']='ShowMyFiles';
				}
				if (!isset($this->nfh['upctitle'])) {
					$this->nfh['upctitle']=gettext('Collect files for the upload queue');
				}
				if (!isset($this->nfh['upctext'])) {
					$this->nfh['upctext']='CollectFiles';
				}
				if (!isset($this->nfh['upltitle'])) {
					$this->nfh['upltitle']=gettext('Upload queued files');
				}
				if (!isset($this->nfh['upltext'])) {
					$this->nfh['upltext']='UploadFiles';
				}
				$this->vpoolSetNode('nfh',array('mod'=>$this->context),$this->nfh);
				$this->vi18nSetMsg($this->context,$this->msgs);
				$cnt='<div id="nfhup">';
				$cnt.=NGSP3.'<a id="nfhupi" class="nfha" title="'.$this->nfh['upititle'].' ">'
						.	$this->nfh['upitext'].'</a>';
				$cnt.=NGSP3.'<a id="nfhupc" class="nfha" title="'.$this->nfh['upctitle'].' ">'
						.	$this->nfh['upctext'].'</a>';
				$cnt.=NGSP3.'<a id="nfhupl" class="nfha" title="'.$this->nfh['upltitle'].' ">'
						.	$this->nfh['upltext'].'</a>'.NGSP3;
				$cnt.='<div id="nfhupm" class="nfh">';
				$cnt.='</div>';
				$cnt.='<div id="nfhis">'.(isset($this->nfh['tnis'])?$this->nfh['tnis']:'').'</div>';
				$cnt.='</div>';
				$_SESSION['FG'][NGCOM]['AnU']=$this->nfh;
			}
			return $cnt;
		}
	}

	protected function taoUpAnU() {
		// BG
		if (isset($_SESSION['FG']['ngcom']['AnU']['who'])) {
			$debug=array();
			if ($this->debug4bg) {
				$debug['sfgfo']=$_SESSION['FG'][$this->context]['AnU']['who'];
				$debug['cnttype']=$_SERVER['CONTENT_TYPE'];
				foreach ($_POST as $k => $v) {
					$debug['post'][]=htmlentities(stripslashes($k)).' = '
					.				 nl2br(htmlentities(stripslashes($v)));
				}
				$debug['files']=var_export($_FILES, true);
			}
			// todo - pay attention to chunks
			// ver fn
			$this->filename = urlencode($_FILES['file']['name']);
			$debug['$Ffn']=$this->filename;
			$debug['$Fto']=PHPWS_SOURCE_DIR.'files/filecabinet/incomming/'.$this->filename;
			$this->filetype = $_FILES['file']['type'];
			$debug['$Fft']=$this->filetype;
			$debug['$FIL']=$_FILES['file'];
			if (!$_FILES['file']['error']) {
				$debug['ccup']=move_uploaded_file($_FILES['file']['tmp_name'], 
							PHPWS_SOURCE_DIR.'files/filecabinet/incoming/'.$this->filename);
				// write log entry	
				PHPWS_Core::log('upload by '.$_SESSION['FG']['ngcom']['AnU']['who']
				.				', file '.$this->filename.', from '.$this->userip
				.				', with '.$_SERVER['HTTP_USER_AGENT'], 'file.log');
			}
			@unlink($_FILES['file']['tmp_name']);
			//$this->conprox='epc';
			if ($this->debug4bg) {
				return json_encode($debug);
			}
			return ' ';
		}
	}
	
	public function recastImg() {
		if (1==1) {
			// in $this->nfh
			// in $this->filename
			if (isset($this->nfh)) {
				if ($this->nfh['srcwidth'] > $this->nfh['targetwidth']
				||  $this->nfh['srcheight'] > $this->nfh['targetheight']) {
					// scale
					$scaleh = $this->nfh['targetheight'] / $this->nfh['srcheight'];
					$scalew = $this->nfh['targetwidth'] / $this->nfh['srcwidth'];
					$scale = $scaleh < $scalew ? $scaleh : $scalew;
					$this->nfh['newheight']=round($this->nfh['srcheight'] * $scale);
					$this->nfh['newwidth']=round($this->nfh['srcwidth'] * $scale);
				} else {
					$this->nfh['newheight']=$this->nfh['srcheight'];
					$this->nfh['newwidth']=$this->nfh['srcwidth'];
				}
				return true;
			}
			return false;
		}
	}
	
	public function recastTn() {
		if (1==1) {
			// in $this->nfh
			// in $this->filename
			if (isset($this->nfh)) {
				if ($this->nfh['srcwidth'] > 100
				||  $this->nfh['srcheight'] > 100) {
					// scale
					$scaleh = 100 / $this->nfh['srcheight'];
					$scalew = 100 / $this->nfh['srcwidth'];
					$scale = $scaleh < $scalew ? $scaleh : $scalew;
					$this->nfh['tnheight']=round($this->nfh['srcheight'] * $scale);
					$this->nfh['tnwidth']=round($this->nfh['srcwidth'] * $scale);
				} else {
					$this->nfh['tnheight']=$this->nfh['srcheight'];
					$this->nfh['tnwidth']=$this->nfh['srcwidth'];
				}
				return true;
			}
			return false;
		}
	}
	
	public function reinforceUp() {
		// &->nfh umode upctitle upctext upltitle upltext
		// $this->context=$this->conprox=$_SESSION['FG']['ngcom']['AnU']['me'];
		// if ((!empty($this->conprox) && $this->conprox == $this->context)
		// ||  (empty($this->conprox)	&& $this->context==NGCOM))
		if (1==1)
		{
			// ggf urlencode $f if name contains spaces
			// ver filename
			$debug='<pre>'.print_r($_SESSION['FG']['ngcom'],true).'</pre>';
			$path=PHPWS_HOME_DIR.$this->nfh['imgpath'];
			clearstatcache();
			$this->nfh['rc']=11;
			if (@filesize($path.$this->filename) > 0) {
				$this->nfh['rc']=12;
				$attr = getimagesize($path.$this->filename);
				if ($attr) {
					$this->nfh['rc']=13;
					list($this->nfh['srcwidth'],
							 $this->nfh['srcheight'],
							 $this->nfh['srctype']) = $attr;
					if ($this->nfh['srcwidth'] > 0 && $this->nfh['srcheight'] > 0) {
						$this->nfh['rc']=14;
						if ($this->recastImg());
								$this->recastTn();
								$this->nfh['rc']=15;
							$tpic=imagecreatetruecolor($this->nfh['newwidth'], $this->nfh['newheight']);
							$tnpic=imagecreatetruecolor($this->nfh['tnwidth'], $this->nfh['tnheight']);
							switch ($this->nfh['srctype']) {
								case IMAGETYPE_JPEG:
								$spic = imagecreatefromjpeg($path.$this->filename);
							break;
							case IMAGETYPE_PNG:
								$spic = imagecreatefrompng($path.$this->filename);
							break;
							case IMAGETYPE_GIF:
								$spic = imagecreatefromgif($path.$this->filename);
								break;
							default:
								$spic=false;
							break;
						}	
						if ($spic) {
							$this->nfh['rc']=16;
							// anycase - just for sec
							if (imagecopyresampled($tpic, $spic,
									0, 0, 0, 0,
									$this->nfh['newwidth'], $this->nfh['newheight'],
									$this->nfh['srcwidth'], $this->nfh['srcheight'])
								) {
								$this->nfh['rc']=17;
								// always 2 png
								if (imagepng($tpic, $path.'re.'.$this->filename.'.png', 9)) {
									$this->nfh['rc']=18;
									if (imagedestroy($tpic)) {
										$this->nfh['rc']=19;
										if (imagecopyresampled($tnpic, $spic,
												0, 0, 0, 0,
												$this->nfh['tnwidth'], $this->nfh['tnheight'],
												$this->nfh['srcwidth'], $this->nfh['srcheight'])
										) {
											$this->nfh['rc']=20;
											if (imagepng($tnpic, $path.'tn.'.$this->filename.'.png', 9)) {
												$this->nfh['rc']=0;	
												$this->nfh['srcname']=$this->filename;	
												$this->nfh['imgtag']='<img src="'.PHPWS_HOME_HTTP.$this->nfh['imgpath']
												.	're.'.$this->filename.'.png'
												. '" width="' . $this->nfh['newwidth']
												. '" height="' . $this->nfh['newheight'] . '" />';
												$this->nfh['tntag']='<img src="'.PHPWS_HOME_HTTP.$this->nfh['imgpath']
												.	'tn.'.$this->filename.'.png'
												. '" width="' . $this->nfh['tnwidth']
												. '" height="' . $this->nfh['tnheight'] . '" />';
												$this->nfh['tntagbg']='background-image: url('
												.	PHPWS_HOME_HTTP.$this->nfh['imgpath'].'tn.'.$this->filename.'.png'
												. ');';
												// 4debug
												// $this->nfh['imgtag']='<pre>'
												// .	htmlentities(print_r($this->nfh,true)).'</pre>';
											} else {
												$this->nfh['imgtag']='<pre>'.print_r($this->nfh['rc'],true).'</pre>';
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	
	protected function getImgIn($pic) {
		if ($this->context==NGCOM) {
			$this->filename=$pic;
			$this->nfh=$_SESSION['FG']['ngcom']['AnU'];
			$this->reinforceUp();
			if ($this->nfh['rc']===0) {
				// feed back
				$_SESSION['FG']['ngcom']['AnU']=$this->nfh;
				return $this->nfh['imgtag'];
			} else {
				return 'Rc'.$this->nfh['rc'];
			}
		}
	}
	
	// :...
	// FC IF
	
	protected function fcFo($fclass='i') {
		// BG
		if ($this->context==NGCOM) {
				$fold=strtr($fclass,'idm','123');
				$fcfs = Cabinet::listFolders($fold);
				$fonas='<option value=" "> </option>';
				if ($fcfs) {
					foreach ($fcfs as $fcf) {
						$_SESSION['FG'][NGCOM]['fcf'][$fcf['title']]=$fcf['id'];
						$fonas.='<option value="'.$fcf['title'].'">'.$fcf['title'].'</option>';
					}
				}
				return json_encode(array('mid'=>NGCOMMID,'fonas'=>$fonas));
		}
	}

	protected function fcPi($fclass='i') {
		// BG
		if ($this->context==NGCOM) {
			$rqfo=false;
			if (isset($_REQUEST['s'])
			&& preg_match('/^[0-9a-zA-Z_\s]*$/',urldecode($_REQUEST['s']))===1)
			{
				(string)$rqfo=urldecode($_REQUEST['s']);
			}
			$picas='';
			$pinas='<option value=" "> </option>';
			if ($rqfo) {
				$foid=$_SESSION['FG'][NGCOM]['fcf'][$rqfo];
				if ($foid) {
					$was = strtr($fclass, array('i'=>'images','d'=>'documents','m'=>'multimedia'));
					$fcdb = new PHPWS_DB($was);
					$fcdb->addWhere('folder_id', $foid);
					$fcdb->addOrder('title');
					$rs = $fcdb->select('all');
					if ($rs) {
						foreach ($rs as $n=>$fcp) {
							$pinas.='<option value="'.$fcp['file_directory'].$fcp['file_name']
							.		'" data-pre="'.$fcp['id'].'">'
							.		$fcp['file_name'].'</option>';
							if ($fclass=='i') {
								$lop=$fcp['width'] > $fcp['height']?'ngfxland':'ngfxport';
								$picas.='<img id="tn'.$n.'" onclick="tao.run.ncl.nclFcTn(this)" src="'.$fcp['file_directory'].'tn/'.$fcp['file_name']
								.		'" alt="'.$fcp['alt'].'" class="'.$lop.'" />' ;
							}
						}
					}
				}
			} 
			return json_encode(array('mid'=>NGCOMMID,'pinas'=>$pinas,'picas'=>$picas));
		}
	}
	
	protected function taoUpPi($fclass='i') {
		// BG
		if ($this->context==NGCOM) {
			if (isset($_SESSION['FG']['ngcom']['img@'])) {
				if (!Current_User::authorized(NGCOM)) {
					Current_User::disallow();
				}
				$debug=array();
				if ($this->debug4bg) {
					$debug['sfgfo']=$_SESSION['FG']['ngcom']['img@'];
					$debug['cnttype']=$_SERVER['CONTENT_TYPE'];
					foreach ($_POST as $k => $v) {
						$debug['post'][]=htmlentities(stripslashes($k)).' = '
						.				 nl2br(htmlentities(stripslashes($v)));
					}
					$debug['files']=var_export($_FILES, true);
				}
				// todo - pay attention to chunks
				
				$foid=$_SESSION['FG']['ngcom']['img@'];
				$this->filename = $_FILES['file']['name'];
				$this->filetype = $_FILES['file']['type'];
				if (!$_FILES['file']['error']) {
					$debug['ccup']=move_uploaded_file($_FILES['file']['tmp_name'], 
						PHPWS_SOURCE_DIR.'images/filecabinet/folder'.$foid.'/'.$this->filename);
					// write log entry
					PHPWS_Core::log('upload by '.$this->userid.':'.$this->userin.':'.$this->userdn
					.				', file '.$fclass.':'.$foid.':'.$this->filename.', from '.$this->userip
					.				', with '.$_SERVER['HTTP_USER_AGENT'], 'file.log');
					// write to db
					$debug['ccdb']=$this->taoFcAPi();
				}
				@unlink($_FILES['file']['tmp_name']);
				if ($this->debug4bg) {
					return json_encode($debug);
				}
				return ' ';
			}
		}
	}
	

	protected function taoFcAPi($fclass='i') {
		if ($this->context==NGCOM) {
			// check authkey - todo
			if (1==1) {
					// image has just to be in the filesystem
					PHPWS_Core::initModClass('filecabinet', 'Image.php');
					$fci = new PHPWS_Image;
					$fci->folder_id=$_SESSION['FG'][NGCOM]['img@'];
					if (isset($this->filename) && isset($this->filetype)) {
						$fci->file_name=$this->filename;
						$fci->file_directory='images/filecabinet/folder'.$fci->folder_id.'/';
						// verify - todo
						$fci->file_type=$this->filetype;
						$tf=$fci->loadDimensions();
						$fci->description='';
						//	test($fci->file_directory);
						$newid=$fci->save(true,false);
						//	test($fci);
						return $newid;
					}
				
			}
		}
	}
	
	protected function fcFlist() 
	{
		if ($this->context==NGCOM) {
			if ($this->conuser) {
				if (Current_User::allow(NGCOM, 'list')) {
					$cnt='<div id="ngcomwop" class="ngwop"><h2 class="ngcomwophx">\<u> FolderList</u>@<u>FileCabinet</u></h2>';
				//	$cnt.=self::NGSP3.self::NGSP3.'<a href="ngcom/op/edit">Editor</a>';
				//	$cnt.=self::NGSP3.self::NGSP3.'<a href="ngcom/op/fcf">FcList</a>'
					$cnt.=self::NGBR;
					$cnt.='<div id="ngcommsg">'.$this->msg.' </div>';
					$fcfs = Cabinet::listFolders("1");
					if ($fcfs) {
						$cnt.=	'<table class="'.NGCOMMID.'ngtable ngtable">'
						.		'<thead class="'.NGCOMMID.'ngthead ngthead">'
						.		'<tr><th>Folder</th><th>Desc</th><th>Public</th><th>Module</th><th>Op</th></tr></thead>'
						.		'<tbody class="'.NGCOMMID.'ngtbody ngtbody">';
						$zebra='';
						//test($fcfs);
						foreach ($fcfs as $fcf) {
							$zebra=='0'?$zebra='1':$zebra='0';
							$_SESSION['FG'][NGCOM]['fcf'][$fcf['id']]=true;
							$cnt.='<tr class="bgcolor'.$zebra.'">'
							.	'<td>'.$fcf['title'].' </td>'
							.	'<td>'.$fcf['description'].' </td>'
							.	'<td>'.($fcf['public_folder']?'Y':'N').'</td>'
							.	'<td>'.($fcf['module_created']?$fcf['module_created']:'<i>any</i>').'</td>'
							.	'<td><a href="ngcom/op/fcpl/s/'.$fcf['id'].'">list</a></td></tr>';
						}
						$cnt.='</tbody></table>';
					} else {
						$cnt.='<p>'.dgettext(NGCOM,'No folders available').'</p>';
					}
					$cnt.='</div>';
					$this->feedBox($cnt);
				}
			}
		}
	}
	
	protected function fcPlist() 
	{
		// FG
		if ($this->context==NGCOM && isset($_SESSION['FG'][NGCOM])) {
			unset($_SESSION['FG'][NGCOM]['x']);
			if ($this->conuser) {
				if (Current_User::allow(NGCOM, 'list')) {
					$jso=array();
					$cnt='<div id="ngcomwop" class=ngwop"><h2 class="ngcomwophx">\<u> Images</u>@<u>FileCabinet</u></h2>'
					.	self::NGSP3.self::NGSP3
					.				'<a href="ngcom/op/fcfl" class="'.NGCOMMID.'nga">FcList</a>'
					.	self::NGSP3.self::NGSP3
					.				'<a id="ncfaqs"'
					.				' data-mod="'.NGCOMMID.'"'
					.				' data-fo="'.$this->rqfo.'"'
					.				' data-ak="'.Current_User::getAuthkey().'"'
					.				' title="'.gettext('collect images for the upload queue')
					.				'" class="'.NGCOMMID.'nga">CollectImages</a>'
					.	self::NGSP3.self::NGSP3
					.				'<a id="ncfaqu"'
					.				' data-mod="'.NGCOMMID.'"'
					.				' data-fo="'.$this->rqfo.'"'
					.				' title="'.gettext('upload collected images from the queue')
					.				'" class="'.NGCOMMID.'nga">UploadImages</a>';
					
					if (1==1) {
						$cnt .= self::NGSP3.self::NGSP3
						.			'<a id="ngcanew"'
						.			' href="ngcom/op/fcpl/s/'.$this->rqfo.'"'
						.			' data-mod="'.NGCOMMID.'"'
						.			' data-fo="'.$this->rqfo.'"'
						.			' title="'.gettext('refresh view')
						.			'" class="'.NGCOMMID.'nga">RefreshView</a>';
					}
					if (isset($this->rqfo)) {
						$foid=isset($_SESSION['FG'][NGCOM]['fcf'][$this->rqfo])?$_SESSION['FG'][NGCOM]['fcf'][$this->rqfo]:false;
						// t/f
						if ($foid) {
							$_SESSION['FG']['ngcom']['img@']=$this->rqfo;
							$fcdb = new PHPWS_DB('images');
							$fcdb->addWhere('folder_id', $this->rqfo);
							$fcdb->addOrder('title');
							$rs = $fcdb->select('all');
							if ($rs) {
								$cnt.=self::NGSP3.self::NGSP3
								.		'<a id="ncfatna" onClick="tao.run.ngcom.ngFcTnReAll()" title="'
								.		gettext('recreate all thumbnail images')
								.		'" class="'.NGCOMMID.'nga">recreateTnAll</a>'.self::NGBR;
							}
							$cnt.='<div id="ncfdq"></div>'.self::NGBR;
							if ($rs) {
								$cnt.='<table class="'.NGCOMMID.'ngtable ngtable">'
								.	'<thead class="'.NGCOMMID.'ngthead ngthead">'
								.	'<tr><th></th><th>'.gettext('Thumbnail')
								.	'</th><th>'.gettext('Image').'</th><th>'.gettext('Desciption')
								.	'</th><th>'.gettext('Size').'</th><th>Op</th></tr></thead>'
								.	'<tbody class="'.NGCOMMID.'ngtbody ngtbody">';
								$zebra='';
								foreach ($rs as $n => $fcp) {
									$x=md5($fcp['file_directory'].$fcp['file_name']);
									$_SESSION['FG'][NGCOM]['x'][$x]=array('d'=>$fcp['file_directory'],
																			'p'=>$fcp['file_name']);
									// image folder, always the same in piclist
									$ifo=$fcp['file_directory'];
									$zebra=='0'?$zebra='1':$zebra='0';
									$cnt.='<tr class="bgcolor'.$zebra.'">'
									.	'<td class="txtright"><input id="ncopcb'.$x.'" type="checkbox" value="1" name="ncopcb" '
									.		'title="NCO301A '.gettext('confirm').'" /></td>'
									.	'<td><a id="ncoptn'.$x.'" class="nclnga" '
									.	' onClick="tao.run.ngcom.ngFcPicView(this,\''
									.	$n.'\')">'
									.		'<img src="'.$fcp['file_directory'].'tn/'.$fcp['file_name']
									.		'" alt="'.$fcp['alt'].'" id="tn'.$x.'" /></a>'.'</td>'
									.	'<td>'.$fcp['file_name'].NGBR.'alt= '.$fcp['alt'].NGBR.'title= '.$fcp['title'].'</td>'
									.	'<td>'.$fcp['description'].'</td>'
									.	'<td>'.($fcp['width']>$fcp['height']?'L':'P').$fcp['width'].'x'.$fcp['height'].'</td>'
									.	'<td><a class="nclnga" >edit</a>'.NGSP3
									.	'<a class="nclnga" onClick="tao.run.ngcom.ngFcTnRe(\''.$x.'\')" title="'
									.		gettext('recreate thumbnail image').'">recreateTn</a>'
									.	NGBR.'<a class="nclnga" onClick="tao.run.ngcom.ngFcRotW(\''.$x.'\')" title="'
									.		gettext('rotate 90° left').'">r&lt;90</a>'
									.	NGSP3.'<a class="nclnga" onClick="tao.run.ngcom.ngFcRotE(\''.$x.'\')" title="'
									.		gettext('rotate 90° right').'">r&gt;90</a>'
									.	NGSP3.'<a class="nclnga" onClick="tao.run.ngcom.ngFcRotS(\''.$x.'\')" title="'
									.		gettext('rotate 180°').'">r180</a>'
									.	NGBR.'c2gif&nbsp;c2jpg&nbsp;c2png</td>'
									.	'</tr>';
									$jso[$n]=array('h'=>$fcp['height'],'w'=>$fcp['width'], 'name'=>$fcp['file_name']);
								}
								$cnt.='</tbody></table>';
							}
						}
					}
					$cnt.='</div>';
					$cnt.='<div id="ncomodal" class="ncomodal ngmodal"><div id="ncomodala">'
					.	'<a id="ncomodalclose" title="'.gettext('close').'" class="ngmodalclose">X</a>'
					.	'<div id="ncomodalcnt"></div></div></div>';
					ngACo::vshrSetNode('ngcomvshr',array('authkey'=>Current_User::getAuthKey(),'httpsrc'=>PHPWS_SOURCE_HTTP));
					if (isset($ifo)) {
						ngACo::vpoolSetNode('ncffi',array( 'fo'=>$this->rqfo, 'ifo'=>str_replace('/tn/','',$ifo)), $jso);
					} else {
						// empty folder
						ngACo::vpoolSetNode('ncffi',array( 'fo'=>$this->rqfo), $jso);
					}
					$this->feedBox($cnt);
				} 
			}
		}
	}
	
	protected function fcTnRe() 
	{
		if ($this->context==NGCOM) {
			$rqx=false;
			if (isset($_REQUEST['x'])
			&& preg_match('/^[0-9a-z]*$/',$_REQUEST['x'])===1)
			{
				(string)$rqx=$_REQUEST['x'];
			}
			if ($rqx) {
				if (isset($_SESSION['FG'][NGCOM]['x'][$rqx])) {
					$ty=strtolower(array_pop(explode('.',$_SESSION['FG'][NGCOM]['x'][$rqx]['p'])));
					$f=$_SESSION['FG'][NGCOM]['x'][$rqx]['d'].$_SESSION['FG'][NGCOM]['x'][$rqx]['p'];
					$ftn=$_SESSION['FG'][NGCOM]['x'][$rqx]['d'].'tn/'.$_SESSION['FG'][NGCOM]['x'][$rqx]['p'];
					list($w, $h) = getimagesize($f);
					if ($w > $h) {
						// landscape
						$wtn=100;
						$htn=round(100 / ($w / $h));
					} else {
						// portrait or square
						$htn=100;
						$wtn=round(100 / ($h / $w));
					}
					$tn = imagecreatetruecolor($wtn, $htn);
					switch ($ty) {
						case 'jpg': case 'jpeg':
							$pic = imagecreatefromjpeg($f);
							break;
						case 'png':
							$pic = imagecreatefrompng($f);
							break;
					}	
					imagecopyresized($tn, $pic, 0, 0, 0, 0, $wtn, $htn, $w, $h);
					// fc tn always png
					imagepng($tn, $ftn);
					imagedestroy();
					return $ftn;
				}
			}
		}
		return '';
	}
	
	protected function fcTnReAll() 
	{
		if ($this->context==NGCOM) {
			if (isset($_SESSION['FG'][NGCOM]['x'])) {
				return implode('--',array_keys($_SESSION['FG'][NGCOM]['x']));
			}
		}
	}
	
	protected function fcImgRot($to)
	{
		if ($this->context==NGCOM) {
			$rqx=false;
			if (isset($_REQUEST['x'])
			&& preg_match('/^[0-9a-z]*$/',$_REQUEST['x'])===1)
			{
				(string)$rqx=$_REQUEST['x'];
			}
			if ($rqx) {
				if (isset($_SESSION['FG'][NGCOM]['x'][$rqx])) {
					$ty=strtolower(array_pop(explode('.',$_SESSION['FG'][NGCOM]['x'][$rqx]['p'])));
					$f=$_SESSION['FG'][NGCOM]['x'][$rqx]['d'].$_SESSION['FG'][NGCOM]['x'][$rqx]['p'];
					//list($w, $h) = getimagesize($f);
					//$ni = imagecreatetruecolor($w, $h);
					switch ($ty) {
						case 'jpg': case 'jpeg':
							$pic = imagecreatefromjpeg($f);
							break;
						case 'png':
							$pic = imagecreatefrompng($f);
							break;
					}	
					switch ($to) 
					{
						case 'w':
							$npic=imagerotate($pic,90,0);
							break;
						case 'e':
							$npic=imagerotate($pic,270,0);
							break;
						case 's':
							$npic=imagerotate($pic,180,0);
							break;
					}
					switch ($ty) {
						case 'jpg': case 'jpeg':
							imagejpeg($npic,$f);
							break;
						case 'png':
							imagepng($npic,$f);
							break;
					}	
					return ' ';
				}
			}
		}
	}
	
	public function feedBox($text,$box=false,$htmlid='')
	{
		if ($this->context==NGCOM) {
			if ($htmlid=='') {
				$cnt='<div>'.$text.'</div>';
			} else {
				$cnt='<div id="'.$htmlid.'" class="ngcomcnt">'
				.	  '<div class="'.NGCOMMID.'box box">'
				.		'<div class="'.NGCOMMID.'box-title box-title"><h1>'.$this->btitle.'*</h1></div>'
				.		'<div class="'.NGCOMMID.'box-content box-content">'.$text.'</div>'
				.	  '</div>'
				.	'</div>';
			}
			if ($box) {
				Layout::add($cnt,'','smallbox');
			} else {
				Layout::add($cnt);
			}
		}
	}

}

?>
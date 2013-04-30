<?php

/**
    * ngRac module part of ngCom for phpWebSite / ngWebSite
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
	define ('NGRAC', 'ngrac');
	define ('NGRACMID', 'nra');
	
class ngRac {

	const RAC = 'ngrac';

	var $context = '';
	var $conuser = '';
	var $isdeity = false;
	var $rgn = '';
	var $rgs = '';
	var $rcmt = '';
	var $msg = '';

	public function __construct()
	{
		$this->context=PHPWS_Core::getCurrentModule().self::RAC;
		$this->conuser=Current_user::isLogged();
		$this->isdeity=Current_user::isDeity();
	}

	public function index($xop)
	{
		// FG
		// todo xop op
		$op = $this->vrq('op');
		switch ($op) {
		case 'nra.edit':
			$this->wop();
			break;
		case 'list':
			$this->listRac();
			break;
		}
	}

	protected function feedBox($text,$box=false,$htmlid='')
	{
		if ($this->context==NGCOM.self::RAC) {
			javascript('jquery');
			javascript('ng_com');
			Layout::addStyle(NGCOM,'style.css');
			if ($htmlid=='') {
				$cnt='<div>'.$text.'</div>';
			} else {
				$cnt='<div id="'.$htmlid.'" class="ngcomcnt">'.$text.'</div>';
			}
			if ($box) {
				Layout::add($cnt,'','smallbox');
			} else {
				Layout::add($cnt);
			}
		}
	}
	
	protected function wop() 
	{
		if ($this->context==NGCOM.self::RAC) {
			if ($this->conuser && $this->isdeity) {
			//	if (Current_User::allow(NGRAC, 'edit')) {
				if (1==1) {
					$form = new PHPWS_Form();
					$form->setAction('ngrac/op/make');
		
					$form->add('rgn', 'text');
					$form->setValue('rgn', $this->rgn);
					$form->setTitle('rgn', gettext('The required rgn [a-z0-9.*]'));
					$form->setSize('rgn', 48);
					$form->setMaxSize('rgn', 64);
					$form->setExtra('rgn', 'class="nclfld"');
			
					$form->add('rcmt', 'text');
					$form->setValue('rcmt', $this->rcmt);
					$form->setTitle('rcmt', gettext('The optional comment [a-zA-Z0-9_ ]'));
					$form->setSize('rcmt', 48);
					$form->setMaxSize('rcmt', 64);
					$form->setExtra('rcmt', 'class="nclfld"');
									
					$form->addSelect('raut', array(	' '=>'...'));
					$form->setTitle('raut', dgettext(NGCOM,'select an authorized from the list'));
					$form->setId('raut', 'nraraut');
					$form->setClass('raut', 'nclfld');
				//	$form->setExtra('raut', 'onchange="tao.run.ncl.nclFcM(this)"');
					
					// textarea in deskform tpl
				
					$form->addSubmit('open', 'Open');
					$form->setExtra('open', 'class="nclbut"');
					$form->addSubmit('make', 'Save');
					$form->setExtra('make', 'class="nclbut"');
					$form->addSubmit('cancel', 'Cancel');
					$form->setExtra('cancel', 'class="nclbut"');
				
					$tpl = $form->getTemplate();
					$tpl['TITLE']='\<u> Workplace</u>@<u>ngRac</u>';
					$tpl['LIST']=dgettext(NGRAC,'ListRac');
					$tpl['RGN_LABEL']='RGN';
					$tpl['RCMT_LABEL']=dgettext(NGCOM,'Notes');
					$tpl['RAUT_LABEL']=dgettext(NGCOM,'Auth');
					$tpl['MSG']=$this->msg;
					$tpl['EDITOR'] = $this->rgs;
					
					$cnt=PHPWS_Template::process($tpl, NGCOM, 'deskform.nra.tpl');
					$this->feedBox($cnt);
					//$this->tocBox();
				}
			} else {
				Current_User::requireLogin();
			}
		} else {
			$this->msg = dgettext(NGRAC, 'not permitted');
		}
	}
	
	protected function _getAuthed($fld)
	{
		if ($this->context==NGCOM.self::RAC) {
		}
	}
	
	protected function vrq($fld)
	{
		if ($this->context==NGCOM.self::RAC) {
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
				if (preg_match('/^nra.edit|list|view|delY|makeOpen|makeSave|makeCancel|fcf|fcp|bu|akey|skey$/',$op)===1) 
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
}


?>
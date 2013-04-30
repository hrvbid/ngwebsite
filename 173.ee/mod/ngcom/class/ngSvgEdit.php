<?php

/**
    * ngSvgEdit module part of ngCom for phpWebSite / ngWebSite
	*
	* hooks svg-edit 	https://code.google.com/p/svg-edit/
	*					https://code.google.com/p/svg-edit/people/list
	*		to ngWebSite/phpWebSite
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
	define ('NGSVGE', 'ngsvgedit');
	define ('NGSVGMID', 'nse');
	
class ngSvgE {

	const NGSVGE = 'ngsvgedit';

	var $context = '';
	var $conuser = '';
	var $isdeity = false;
	var $rgn = '';
	var $rgs = '';
	var $rcmt = '';
	var $msg = '';

	public function __construct()
	{
		$this->context=PHPWS_Core::getCurrentModule().self::NGSVGE;
		$this->conuser=Current_user::isLogged();
		$this->isdeity=Current_user::isDeity();
	}
	
	public function index($xop)
	{
		// FG
		// todo xop op
		$op = $this->vrq('op');
		switch ($op) {
		case 'nse.edit':
			$this->wop();
			break;
		case 'nse.in':
			$this->wopIn();
			break;
		}
	}
	
	protected function feedBox($text,$box=false,$htmlid='')
	{
		if ($this->context==NGCOM.self::NGSVGE) {
			javascript('jquery');
			javascript('jquery_ui');
			javascript('ng_com');
			Layout::addStyle(NGCOM,'style.css');
		//	javascript('ng_com/svg-edit');
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
		if ($this->context==NGCOM.self::NGSVGE) {
			if ($this->conuser) {
			//	if (Current_User::allow(NGSVGE, 'edit')) {
				if (1==1) {
					$thisurl=PHPWS_SOURCE_HTTP.'javascript/ng_com/svg-edit/';
					$infra=file_get_contents(PHPWS_SOURCE_DIR.'javascript/ng_com/svg-edit/embedapi.tpl');
					$cnt=str_replace('{THISURL}',$thisurl,$infra);
					$this->feedBox($cnt,false,'svgwop');
				}
			}
		}
	}
	
	protected function wopIn() 
	{
		if ($this->context==NGCOM.self::NGSVGE) {
			if ($this->conuser) {
			//	if (Current_User::allow(NGSVGE, 'edit')) {
				if (1==1) {
					$thisurl=PHPWS_SOURCE_HTTP.'javascript/ng_com/svg-edit/';
					$infra=file_get_contents(PHPWS_SOURCE_DIR.'javascript/ng_com/svg-edit/svg-editor.tpl');
					$cnt=str_replace('{THISURL}',$thisurl,$infra);
					$_SESSION['BG']=$cnt;
				}
			}
		}
	}
	
	protected function vrq($fld)
	{
		if ($this->context==NGCOM.self::NGSVGE) {
			switch ($fld) {
			case 'op':
				$op=@$_REQUEST['op'].@$_REQUEST['open'].@$_REQUEST['make'].@$_REQUEST['cancel'].@$_REQUEST['skey'];
				if (preg_match('/^nse.edit|nse.in|list|view|delY|makeOpen|makeSave|makeCancel|fcf|fcp|bu|akey|skey$/',$op)===1) 
				{
					return $op;
				} else {
					return '';
				}
				break;
			}
		}
	}
}
 ?>
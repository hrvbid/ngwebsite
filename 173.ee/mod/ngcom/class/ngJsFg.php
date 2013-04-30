<?php

class ngJsFg {

	const PATXAOP = '/[a-zA-Z]*[a-zA-Z]/';
	
	var $context = '';
	var $conuser = '';

    public function __construct()
	{
		if (defined('NGCOM')) {
			$this->context=PHPWS_Core::getCurrentModule();
			$this->conuser=Current_user::isLogged();
		}
	}
	
	public function confirm($mod,$iid,array $vars)
	{
			$html='<a id="'.$mod.$iid.'" onclick="tao.run.confirm(this)"';
			foreach ($vars as $k=>$v) {
				if ($k=='txt') continue;
				$html.=' data-'.$k.'="'.htmlentities($v).'"';
			}
			$html.='>'.$vars['txt'].'</a>';
			return $html;
	}
	
}

?>
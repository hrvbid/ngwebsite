<?php

	function ngreadme_install(&$content) {
	
		$sql=array();
		// need 32 bit unsigned values
		$sql[]='alter table phpws_key change item_id item_id int(11) unsigned';
		
			foreach ($sql as $stmt) {
				$rc=PHPWS_DB::query($stmt);
				if ($rc=="1") {
					$content[] = $stmt;
					$content[] = ':.. ok';
				} else {
					$content[] = PHPWS_DB::lastQuery();
					$content[] = ':.. '.$rc->message.' = ignored';
				}
			}
		return true;
	}

?>
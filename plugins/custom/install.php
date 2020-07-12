<?php

$this->logger($plugin->getString('creatingtb'));

$this->db->query("CREATE TABLE `".$this->db->prefix("rmb_plg_custom")."` (
`id_cus` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`titulo` VARCHAR( 255 ) NOT NULL ,
`content` TEXT NOT NULL ,
`link` VARCHAR( 255 ) NOT NULL
) TYPE=MYISAM ;");

if ($this->db->error()!=''){
	$this->logger(_AM_RMB_DBERROR."<br />".$this->db->error());
} else {
	$this->logger($plugin->getString('tblok'));
}

?>
<?php

$this->logger($plugin->getString('deleting'));

$this->db->queryF('DROP TABLE `'.$this->db->prefix("rmb_plg_custom")."`");

if ($this->db->error()!=''){
	$this->logger(_AM_RMB_DBERROR."<br />".$this->db->error());
} else {
	$this->logger($plugin->getString('deletingok'));
}

?>
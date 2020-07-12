<?php
// $Id: functions.php,v 0.6 29/11/2006 14:52 BitC3R0 Exp $  //
// -------------------------------------------------------------  //
// RMSOFT Bulletin 1.0                                            //
// Boletín Informativo Avanzado                                   //
// CopyRight © 2006. Red México Soft                              //
// Autor: BitC3R0                                                 //
// http://www.redmexico.com.mx                                    //
// http://www.xoops-mexico.net                                    //
// --------------------------------------------                   //
// This program is free software; you can redistribute it and/or  //
// modify it under the terms of the GNU General Public License as //
// published by the Free Software Foundation; either version 2 of //
// the License, or (at your option) any later version.            //
//                                                                //
// This program is distributed in the hope that it will be useful,//
// but WITHOUT ANY WARRANTY; without even the implied warranty of //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the   //
// GNU General Public License for more details.                   //
//                                                                //
// You should have received a copy of the GNU General Public      //
// License along with this program; if not, write to the Free     //
// Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, //
// MA 02111-1307 USA                                              //
// -------------------------------------------------------------  //
// @copyright: © 2006. BitC3R0.                                   //
// @author: BitC3R0                                               //
// @package: RMSOFT Bulletin 1.0                                  //
// @version: 0.6	                                              //

function rmbMakeNav(){
	global $tpl;
	
	$tpl->append('navItems', array('link'=>'index.php', 'img'=>'../images/navhome.png','text'=>_AM_RMB_CURSTATE));
	$tpl->append('navItems', array('link'=>'index.php?op=show', 'img'=>'../images/navbols.png','text'=>_AM_RMB_BULLETINS));
	$tpl->append('navItems', array('link'=>'sended.php', 'img'=>'../images/navsent.png','text'=>_AM_RMB_SENDED));
	$tpl->append('navItems', array('link'=>'users.php', 'img'=>'../images/navusers.png','text'=>_AM_RMB_USERSSUB));
	$tpl->append('navItems', array('link'=>'email.php', 'img'=>'../images/navemail.png','text'=>_AM_RMB_EMAILCONFIG));
	$tpl->append('navItems', array('link'=>'plugins.php', 'img'=>'../images/navplugs.png','text'=>_AM_RMB_PLUGINS));
	$tpl->append('navItems', array('link'=>'about.php', 'img'=>'../images/about.png','text'=>_AM_RMB_ABOUTMOD));
	echo $tpl->fetch(XOOPS_ROOT_PATH.'/modules/rmbulletin/admin/tpls/rmb_navbar.html');
	
}

function rmbMakeFooter(){
	return "<div style='padding: 4px; margin-top: 10px; font-size: 10px; text-align: center;'>
			Powered by <strong><a href='http://www.xoops-mexico.net/' target='_blank'>RMSOFT Bulletin ".rmbGetVersion()."</a></strong>. 
			Develpment by <a href='http://www.redmexico.com.mx' target='_blank'>Red M&eacute;xico Soft</a>.</div>";
}

function rmbGetVersion(){
	return "1.0";
}

/**
 * Escribe una función JavaScript para cerraqr
 * la ventana actual dependiendo de su ventana padre
 */
function closeOpenner($msg=''){
	$rtn = "<script type='text/javascript'>
				if (window.opener){
				";
				if ($msg!=''){
					$rtn .= "alert('$msg');\n";
				}
	$rtn .= "
					window.close();
				} else {
				";
	$rtn .= "
					window.location = 'index.php';
				}
			  </script>";
	return $rtn;
}

function getVersion(&$version){
	
	$rtn = $version['number'];

	if ($version['revision'] > 0){
		$rtn .= '.' . $version['revision'] / 10;
	} else {
		$rtn .= '.0';
	}
	
	switch($version['status']){
		case '-3':
			$rtn .= ' alfa';
			break;
		case '-2':
			$rtn .= ' beta';
			break;
		case '-1':
			$rtn .= ' final';
			break;
		case '0':
			break;
	}
	
	return $rtn;
	
}

function deleteBols(){
	$db = Database::getInstance();
	
	$result = $db->query("SELECT * FROM ".$db->prefix("rmb_boletines")." WHERE sended='1' AND eliminar='1' AND fechaeliminar<='".time()."'");
	while ($row = $db->fetchArray($result)){
		if (file_exists(XOOPS_ROOT_PATH.'/cache/boletin-'.$row['fechaenvio'].'.html')){
		 	unlink(XOOPS_ROOT_PATH.'/cache/boletin-'.$row['fechaenvio'].'.html');
		}
		$boletin = new RMBulletin($row['id_bol']);
		$boletin->delete();
	}
}
?>

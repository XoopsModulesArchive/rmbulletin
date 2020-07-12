<?php
/*******************************************************************
* $Id: users.php,v 1.0 24/10/2006 11:47 BitC3R0 Exp $              *
* ---------------------------------------------------              *
* RMSOFT Bulletin 1.0                                              *
* Módulo para el manejo y publicación de boletínes                 *
* CopyRight © 2006. Red México Soft                                *
* Autor: BitC3R0                                                   *
* http://www.redmexico.com.mx                                      *
* http://www.xoops-mexico.net                                      *
* --------------------------------------------                     *
* This program is free software; you can redistribute it and/or    *
* modify it under the terms of the GNU General Public License as   *
* published by the Free Software Foundation; either version 2 of   *
* the License, or (at your option) any later version.              *
*                                                                  *
* This program is distributed in the hope that it will be useful,  *
* but WITHOUT ANY WARRANTY; without even the implied warranty of   *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the     *
* GNU General Public License for more details.                     *
*                                                                  *
* You should have received a copy of the GNU General Public        *
* License along with this program; if not, write to the Free       *
* Software Foundation, Inc., 59 Temple Place, Suite 330, Boston,   *
* MA 02111-1307 USA                                                *
* ---------------------------------------------------              *
* sended.php:                                                      *
* Control ded boletines que han sido enviados                      *
* ---------------------------------------------------              *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin 1.0                                    *
* @version: 1.0                                                    *
* @modificado: 08/09/2006 10:47:26 a.m.                            *
*******************************************************************/
define('RMBULLETIN_LOCATION','sended');

include 'header.php';


function showSended(){
	global $db, $mc;
	
	xoops_cp_header();
	rmbMakeNav();
	$table = new RMTable(true);
	$table->setTableClass('outer');
	$table->openTbl();
	$table->openRow();
	$table->addCell(_AM_RMB_BOLSTITLE,1,4);
	
	$result = $db->query("SELECT * FROM ".$db->prefix("rmb_boletines")." WHERE sended='1' ORDER BY fechaenvio DESC LIMIT 0,20");
	$table->closeRow();
	$table->setRowClass('head');
	$table->openRow();
		$table->addCell(_AM_RMB_TITLE,0,'',$align='center');
		$table->addCell(_AM_RMB_CREATED,0,'',$align='center');
		$table->addCell(_AM_RMB_PUBLISH,0,'',$align='center');
		$table->addCell(_AM_RMB_OPTIONS,0,'',$align='center');
	$table->closeRow();
	$table->setRowClass('even,odd', true);
	while ($row = $db->fetchArray($result)){
		$table->openRow();
		$table->addCell($row['titulo']);
		$table->addCell(date($mc['format_date'],$row['fecha']),0,'','center');
		$table->addCell(date($mc['format_date'],$row['fechaenvio']),0,'','center');
		$table->addCell("<a href='?op=del&amp;id=$row[id_bol]'>"._DELETE."</a> &bull;
		<a href='../view.php?id=$row[id_bol]' target='_blank'>"._AM_RMB_VIEW."</a> &bull;
		<a href='?op=notsend&amp;id=$row[id_bol]'>"._AM_RMB_ASNOTSEND."</a>",0,'','center');
		$table->closeRow();
	}
	
	$table->closeRow();
	$table->closeTbl();
	$table = null;
	
	echo "<br />";
	
	echo rmbMakeFooter();
	
	xoops_cp_footer();
}

function markNotSend(){
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	
	if ($id<=0){
		redirect_header('sended.php', 1, _AM_RMB_NOTVALID);
		die();
	}
	
	$boletin = new RMBulletin($id);
	if ($boletin->errors()!=''){
		redirect_header('sended.php', 1, _AM_RMB_NOTEXISTS);
		die();
	}
	
	$boletin->setSended(0);
	if ($boletin->save()){
		redirect_header('sended.php', 1, _AM_RMB_DBOK);
	} else {
		redirect_header('sended.php', 1, _AM_RMB_DBERROR . "<br />" . $this->errors());
	}
}


function rmbDelete(){
	
	$ok = isset($_POST['ok']) ? $_POST['ok'] : 0;
	$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
	
	if ($id<=0){ header('location: index.php'); die(); }
	
	if ($ok){
		$boletin = new RMBulletin($id);
		if (!$boletin->delete()){
			redirect_header('index.php', 1, sprintf(_AM_RMB_ERRONDELETE, $boletin->errors()));
		} else {
			redirect_header('index.php', 1, _AM_RMB_DBOK);
		}
	} else {
		$boletin = new RMBulletin($id);
		$hiddens['op'] = 'del';
		$hiddens['ok'] = 1;
		$hiddens['id'] = $id;
		xoops_cp_header();
		xoops_confirm($hiddens, 'index.php', sprintf(_AM_RMB_DELCONFIRM, $boletin->getVar('titulo')), '', $addtoken = true);
		xoops_cp_footer();
	}
	
}


$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';

switch ($op){
	case 'notsend':
		markNotSend();
		break;
	case 'del':
		rmbDelete();
		break;
	default:
		showSended();
		break;		
}

?>
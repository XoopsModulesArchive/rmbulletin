<?php
/*******************************************************************
* $Id: index.php,v 1.1 10/09/2006 00:57 BitC3R0 Exp $              *
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
* index.php:                                                       *
* Archivo de registro de boletines                                 *
* ---------------------------------------------------              *
* @copyright: © 2006. BitC3R0.                                     *
* @autor: BitC3R0                                                  *
* @paquete: RMSOFT Bulletin v1.0                                   *
* @version: 1.1                                                    *
* @modificado: 10/09/2006 12:57:52 a.m.                            *
*******************************************************************/
$template = 'rmb_archive.html';
include 'header.php';

include_once 'include/plugins.functions.php';

include_once 'admin/functions.php';
deleteBols();

$result = $db->query("SELECT * FROM ".$db->prefix("rmb_boletines")." WHERE sended='1' ORDER BY fechaenvio DESC LIMIT 0,30");
while ($row = $db->fetchArray($result)){
	$tpl->append('boletines', array('id'=>$row['id_bol'],'titulo'=>$myts->makeTboxData4Show($row['titulo']),
			'intro'=>substr($myts->makeTareaData4Show($row['introduccion']), 0, 150).' ...','fecha'=>date($mc['format_date'],$row['fechaenvio']),
			'link'=>$row['fechaenvio']));
}

$tpl->assign('message',_RMB_ARCHIVEMSG);
$tpl->assign('boletins_title', _RMB_ARCHIVETITLE);
$tpl->assign('lang_title', _RMB_LANG_TITLE);
$tpl->assign('lang_fecha', _RMB_LANG_FECHA);
$tpl->assign('lang_intro',_RMB_LANG_INTRO);
$tpl->assign('footer', showFooter());

include XOOPS_ROOT_PATH.'/footer.php';

?>